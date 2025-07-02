<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Entradas extends Controller
{
    public function index()
    {
        $titulo = 'Entradas';
        $items = Entrada::select(
            'entradas.*',
            'users.name as nombre_usuario',
            'productos.nombre as nombre_producto',
            'categorias.nombre as categoria',
            'proveedores.nombre as proveedor',
            'productos.marca',
            'productos.modelo'
        )
            ->join('users', 'entradas.user_id', '=', 'users.id')
            ->join('productos', 'entradas.producto_id', '=', 'productos.id')
            ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->leftJoin('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
            ->get();
        return view('modules.entradas.index', compact('titulo', 'items'));
    }

    public function create($id)
    {
        $titulo = 'Entrada de Productos';
        $item = Producto::find($id);
        return view('modules.entradas.create', compact('titulo', 'item'));
    }

    public function store(Request $request)
    {
        try {
            // Crear entrada
            $entrada = new Entrada();
            $entrada->user_id = Auth::user()->id;
            $entrada->producto_id = $request->id;
            $entrada->cantidad = $request->cantidad;
            $entrada->fecha_compra = $request->fecha_compra;
            $entrada->save();

            // Actualizar stock del producto
            $producto = Producto::find($request->id);
            $producto->cantidad += $request->cantidad;
            $producto->save();

            // Adjuntar documentos (solo a la entrada)
            if ($request->hasFile('orden_compra')) {
                foreach ($request->file('orden_compra') as $archivo) {
                    $ruta = $archivo->storeAs('ordenes_compra', $archivo->getClientOriginalName(), 'public');

                    $doc = Documento::firstOrCreate(
                        ['archivo' => $ruta, 'tipo' => 'orden_compra'],
                        ['archivo' => $ruta, 'tipo' => 'orden_compra']
                    );

                    $entrada->documentos()->attach($doc->id);
                }
            }

            if ($request->hasFile('factura')) {
                foreach ($request->file('factura') as $archivo) {
                    $ruta = $archivo->storeAs('facturas', $archivo->getClientOriginalName(), 'public');

                    $doc = Documento::firstOrCreate(
                        ['archivo' => $ruta, 'tipo' => 'factura'],
                        ['archivo' => $ruta, 'tipo' => 'factura']
                    );

                    $entrada->documentos()->attach($doc->id);
                }
            }

            return to_route('productos')->with('success', 'Entrada exitosa');
        } catch (\Throwable $th) {
            return to_route('productos')->with('error', 'No pudo Entrar: ' . $th->getMessage());
        }
    }


    private function guardarDocumentosEntrada(Request $request, Producto $producto)
    {
        if ($request->hasFile('orden_compra')) {
            foreach ($request->file('orden_compra') as $archivo) {
                $nombreArchivo = $archivo->getClientOriginalName();
                $rutaRelativa = 'ordenes_compra/' . $nombreArchivo;

                // Verificar si ya existe en la base de datos
                $documentoExistente = Documento::where('archivo', $rutaRelativa)->where('tipo', 'orden_compra')->first();

                if (!$documentoExistente) {
                    $archivo->storeAs('ordenes_compra', $nombreArchivo, 'public');
                    $documentoExistente = Documento::create([
                        'tipo' => 'orden_compra',
                        'archivo' => $rutaRelativa,
                    ]);
                }

                $producto->documentos()->syncWithoutDetaching($documentoExistente->id);
            }
        }

        if ($request->hasFile('factura')) {
            foreach ($request->file('factura') as $archivo) {
                $nombreArchivo = $archivo->getClientOriginalName();
                $rutaRelativa = 'facturas/' . $nombreArchivo;

                $documentoExistente = Documento::where('archivo', $rutaRelativa)->where('tipo', 'factura')->first();

                if (!$documentoExistente) {
                    $archivo->storeAs('facturas', $nombreArchivo, 'public');
                    $documentoExistente = Documento::create([
                        'tipo' => 'factura',
                        'archivo' => $rutaRelativa,
                    ]);
                }

                $producto->documentos()->syncWithoutDetaching($documentoExistente->id);
            }
        }
    }


    public function show(string $id)
    {
        $titulo = 'Editar Entradas';
        $items = Entrada::select(
            'entradas.*',
            'users.name as nombre_usuario',
            'productos.nombre as nombre_producto',
            'categorias.nombre as categoria',
            'proveedores.nombre as proveedor',
            'productos.marca',
            'productos.modelo'
        )
            ->join('users', 'entradas.user_id', '=', 'users.id')
            ->join('productos', 'entradas.producto_id', '=', 'productos.id')
            ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->leftJoin('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
            ->where('entradas.id', $id)
            ->first();
        return view('modules.entradas.show', compact('titulo', 'items'));
    }

    public function edit(string $id)
    {
        $titulo = 'Editar Entradas';
        $item = Entrada::select(
            'entradas.*',
            'users.name as nombre_usuario',
            'productos.nombre as nombre_producto',
            'categorias.nombre as categoria',
            'proveedores.nombre as proveedor',
            'productos.marca',
            'productos.modelo'
        )
            ->join('users', 'entradas.user_id', '=', 'users.id')
            ->join('productos', 'entradas.producto_id', '=', 'productos.id')
            ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->leftJoin('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
            ->where('entradas.id', $id)
            ->first();
        return view('modules.entradas.edit', compact('titulo', 'item'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $entrada = Entrada::findOrFail($id);
            $cantidad_anterior = $entrada->cantidad;

            // Actualizar datos
            $entrada->cantidad = $request->cantidad;
            $entrada->fecha_compra = $request->fecha_compra;
            $entrada->save();

            // Actualizar stock del producto
            $producto = Producto::findOrFail($request->producto_id);
            $producto->cantidad = $producto->cantidad - $cantidad_anterior + $request->cantidad;
            $producto->save();

            // Reemplazar documentos solo si se suben nuevos
            if ($request->hasFile('orden_compra')) {
                // Eliminar ordenes actuales solo de esta entrada (no del sistema)
                $documentos_orden = $entrada->documentos()->where('tipo', 'orden_compra')->get();
                $entrada->documentos()->detach($documentos_orden->pluck('id'));

                foreach ($request->file('orden_compra') as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $ruta = 'ordenes_compra/' . $nombre;

                    $documento = Documento::firstOrCreate(
                        ['archivo' => $ruta, 'tipo' => 'orden_compra'],
                        ['archivo' => $archivo->storeAs('ordenes_compra', $nombre, 'public')]
                    );

                    $entrada->documentos()->attach($documento->id);
                }
            }

            if ($request->hasFile('factura')) {
                // Eliminar facturas actuales solo de esta entrada
                $documentos_factura = $entrada->documentos()->where('tipo', 'factura')->get();
                $entrada->documentos()->detach($documentos_factura->pluck('id'));

                foreach ($request->file('factura') as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $ruta = 'facturas/' . $nombre;

                    $documento = Documento::firstOrCreate(
                        ['archivo' => $ruta, 'tipo' => 'factura'],
                        ['archivo' => $archivo->storeAs('facturas', $nombre, 'public')]
                    );

                    $entrada->documentos()->attach($documento->id);
                }
            }

            return to_route('entradas')->with('success', 'Entrada actualizada correctamente');
        } catch (\Throwable $th) {
            return to_route('entradas')->with('error', 'Error al actualizar: ' . $th->getMessage());
        }
    }

    public function destroy(string $id, Request $request)
    {
        try {
            $entrada = Entrada::findOrFail($id);
            $cantidad_compra = $entrada->cantidad;

            // Actualiza cantidad del producto
            $producto = Producto::findOrFail($request->producto_id);
            $producto->cantidad -= $cantidad_compra;
            $producto->save();

            // Solo elimina la entrada (no toca documentos ni archivos)
            $entrada->delete();

            return to_route('entradas')->with('success', 'Entrada eliminada con éxito');
        } catch (\Throwable $th) {
            return to_route('entradas')->with('error', 'No se pudo eliminar la entrada: ' . $th->getMessage());
        }
    }
}
