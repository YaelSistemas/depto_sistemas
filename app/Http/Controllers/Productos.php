<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Productos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Productos';
        $items = Producto::select(
            'productos.*',
            'categorias.nombre as nombre_categoria',
            'proveedores.nombre as nombre_proveedor'
        )
            ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->leftJoin('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
            ->get();

        return view('modules.productos.index', compact('items', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->has('reset')) {
            session()->forget(['orden_compra_ids', 'factura_ids', 'fecha_compra_guardada']);
        }

        $titulo = 'Crear Producto';
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $procesadores = $this->obtenerListaDeProcesadores();

        return view('modules.productos.create', compact('titulo', 'categorias', 'proveedores', 'procesadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Producto();
            $item->user_id = Auth::id();
            $item->categoria_id = $request->categoria_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->marca = $request->marca;
            $item->modelo = $request->modelo;
            $item->no_serie = $request->no_serie;
            $item->cantidad = $request->cantidad;
            $item->ram = $request->ram;
            $item->procesador = $request->procesador;
            $item->tipo_almacenamiento = $request->tipo_almacenamiento;
            $item->capacidad_almacenamiento = $request->capacidad_almacenamiento;
            $item->fecha_compra = $request->fecha_compra;
            $item->save();

            if ($request->filled('usar_facturas_guardadas')) {
                $ordenIds = session('orden_compra_ids', []);
                $facturaIds = session('factura_ids', []);
                $item->documentos()->attach($ordenIds);
                $item->documentos()->attach($facturaIds);
            } else {
                $ordenIds = [];
                $facturaIds = [];

                if ($request->hasFile('orden_compra')) {
                    foreach ($request->file('orden_compra') as $archivo) {
                        $docId = $this->guardarDocumentoCompartido($archivo, 'orden_compra', 'ordenes_compra');
                        $item->documentos()->attach($docId);
                        $ordenIds[] = $docId;
                    }
                }

                if ($request->hasFile('factura')) {
                    foreach ($request->file('factura') as $archivo) {
                        $docId = $this->guardarDocumentoCompartido($archivo, 'factura', 'facturas');
                        $item->documentos()->attach($docId);
                        $facturaIds[] = $docId;
                    }
                }

                // Guardar en sesión si se va a crear otro producto
                if ($request->accion === 'guardar_y_nuevo') {
                    session([
                        'orden_compra_ids' => $ordenIds,
                        'factura_ids' => $facturaIds,
                        'fecha_compra_guardada' => \Carbon\Carbon::parse($item->fecha_compra)->format('Y-m-d'),
                    ]);
                }
            }

            // Subir imagen si se guardó correctamente
            $imagenOk = false;
            if ($item->id && $request->hasFile('imagen')) {
                $imagenOk = $this->subir_imagen($request, $item->id);
            }

            // Determinar mensaje
            $mensaje = 'Producto creado';
            if ($imagenOk) {
                $mensaje .= ' y con imagen';
            } elseif ($request->hasFile('imagen')) {
                $mensaje .= ', pero sin imagen';
            } else {
                $mensaje .= ' sin imagen';
            }

            // Redirección según botón
            if ($request->accion === 'guardar_y_nuevo') {
                return redirect()->route('productos.create')->with('success', $mensaje . '. Puedes registrar otro.');
            }

            return redirect()->route('productos')->with('success', $mensaje);
        } catch (\Throwable $th) {
            return redirect()->route('productos')->with('error', 'Error al crear el producto: ' . $th->getMessage());
        }
    }


    public function subir_imagen($request, $id_producto)
    {
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public'); // guarda en storage/app/public/productos

            $producto = Producto::find($id_producto);
            $producto->imagen_producto = $rutaImagen; // guarda "productos/nombre.jpg"
            return $producto->save();
        }

        return false;
    }

    public function cambiarImagen(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'nueva_imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        // eliminar imagen anterior si existe
        if ($producto->imagen_producto && Storage::disk('public')->exists($producto->imagen_producto)) {
            Storage::disk('public')->delete($producto->imagen_producto);
        }

        $ruta = $request->file('nueva_imagen')->store('productos', 'public');
        $producto->imagen_producto = $ruta;
        $producto->save();

        return redirect()->route('productos')->with('success', 'Imagen actualizada correctamente.');
    }

    private function subir_archivos($request, $nombreCampo, $carpeta)
    {
        $paths = [];

        if ($request->hasFile($nombreCampo)) {
            foreach ($request->file($nombreCampo) as $archivo) {
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
                $ruta = $archivo->storeAs($carpeta, $nombreArchivo, 'public');
                $paths[] = $ruta;
            }
        }

        return $paths;
    }

    private function guardarDocumentoCompartido($archivo, $tipo, $carpeta)
    {
        $nombreArchivo = $archivo->getClientOriginalName();
        $rutaRelativa = $carpeta . '/' . $nombreArchivo;

        // Verifica si ya existe un documento con esa ruta
        $documentoExistente = \App\Models\Documento::where('archivo', $rutaRelativa)->where('tipo', $tipo)->first();

        if ($documentoExistente) {
            return $documentoExistente->id;
        }

        // Si no existe, lo guardamos en disco y lo registramos
        $archivo->storeAs($carpeta, $nombreArchivo, 'public');

        $nuevo = \App\Models\Documento::create([
            'tipo' => $tipo,
            'archivo' => $rutaRelativa,
        ]);

        return $nuevo->id;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar Producto';
        $items = Producto::select(
            'productos.*',
            'categorias.nombre as nombre_categoria',
            'proveedores.nombre as nombre_proveedor'
        )
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->join('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
            ->where('productos.id', $id)
            ->first();
        return view('modules.productos.show', compact('titulo', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Producto';
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $item = Producto::find($id);

        $procesadores = $this->obtenerListaDeProcesadores();

        return view('modules.productos.edit', compact('item', 'titulo', 'categorias', 'proveedores', 'procesadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Producto::findOrFail($id);

            $item->categoria_id = $request->categoria_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->marca = $request->marca;
            $item->modelo = $request->modelo;
            $item->no_serie = $request->no_serie;
            $item->cantidad = $request->cantidad;
            $item->fecha_compra = $request->fecha_compra;
            $item->ram = $request->ram;
            $item->procesador = $request->procesador;
            $item->tipo_almacenamiento = $request->tipo_almacenamiento;
            $item->capacidad_almacenamiento = $request->capacidad_almacenamiento;
            $item->save();

            // === ORDEN DE COMPRA ===
            if ($request->hasFile('orden_compra')) {
                // Elimina los anteriores de este tipo
                $item->documentos()->wherePivot('producto_id', $item->id)
                    ->where('tipo', 'orden_compra')
                    ->each(function ($doc) {
                        Storage::disk('public')->delete($doc->archivo);
                        $doc->delete();
                    });

                foreach ($request->file('orden_compra') as $archivo) {
                    $docId = $this->guardarDocumentoCompartido($archivo, 'orden_compra', 'ordenes_compra');
                    $item->documentos()->attach($docId);
                }
            }

            // === FACTURAS ===
            if ($request->hasFile('factura')) {
                $item->documentos()->wherePivot('producto_id', $item->id)
                    ->where('tipo', 'factura')
                    ->each(function ($doc) {
                        Storage::disk('public')->delete($doc->archivo);
                        $doc->delete();
                    });

                foreach ($request->file('factura') as $archivo) {
                    $docId = $this->guardarDocumentoCompartido($archivo, 'factura', 'facturas');
                    $item->documentos()->attach($docId);
                }
            }

            return to_route('productos')->with('success', 'Producto actualizado correctamente');
        } catch (\Throwable $th) {
            return to_route('productos')->with('error', 'Error al actualizar: ' . $th->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Producto::find($id);
            $item->delete();
            return to_route('productos')->with('success', 'Producto Eliminado Exitosamente');
        } catch (\Throwable $th) {
            return to_route('productos')->with('error', 'Fallo al Eliminar Producto' . $th->getMessage());
        }
    }

    public function estado($id, $estado)
    {
        $item = Producto::find($id);
        $item->activo = $estado;
        return $item->save();
    }

    private function obtenerListaDeProcesadores()
    {
        return [
            "i3-10110U",
            "i3-1115G4",
            "i5-10210U",
            "i5-10300H",
            "i5-1135G7",
            "i5-11400H",
            "i5-1235U",
            "i5-1240P",
            "i5-12500H",
            "i5-1335U",
            "i5-1340P",
            "i5-13500H",
            "i5-1445U",
            "i5-1450P",
            "i5-14600H",
            "i7-10510U",
            "i7-10750H",
            "i7-1165G7",
            "i7-11800H",
            "i7-1255U",
            "i7-1260P",
            "i7-12700H",
            "i7-1355U",
            "i7-1360P",
            "i7-13700H",
            "i7-1465U",
            "i7-14700H",
            "i7-1470P",
            "Ryzen 3 4300U",
            "Ryzen 3 5300U",
            "Ryzen 3 7320U",
            "Ryzen 5 4500U",
            "Ryzen 5 4600H",
            "Ryzen 5 5500U",
            "Ryzen 5 5600H",
            "Ryzen 5 5600U",
            "Ryzen 5 5625U",
            "Ryzen 5 6600H",
            "Ryzen 5 6600U",
            "Ryzen 5 7530U",
            "Ryzen 5 7640HS",
            "Ryzen 5 8540U",
            "Ryzen 7 4700U",
            "Ryzen 7 4800H",
            "Ryzen 7 4800U",
            "Ryzen 7 5700U",
            "Ryzen 7 5700G",
            "Ryzen 7 5800H",
            "Ryzen 7 5800U",
            "Ryzen 7 6800H",
            "Ryzen 7 6800U",
            "Ryzen 7 7735U",
            "Ryzen 7 7840HS",
            "Ryzen 7 8840U",
            "Ryzen 7 8845HS",
            "Ryzen 9 4900H",
            "Ryzen 9 4900HS",
            "Ryzen 9 5900HS",
            "Ryzen 9 5900HX",
            "Ryzen 9 6900HS",
            "Ryzen 9 6900HX",
            "Ryzen 9 7940HS",
            "Ryzen 9 7945HX",
            "Ryzen 9 8945HS",
            "Otro"
        ];
    }

    public function verOrdenesConFacturas()
    {
        $productos = \App\Models\Producto::with([
            'documentos_orden',
            'documentos_factura',
            'entregas_cartuchos' // <- ya no uses 'cartuchos'
        ])->get();

        return view('modules.productos.ordenes_facturas_index', compact('productos'));
    }
}
