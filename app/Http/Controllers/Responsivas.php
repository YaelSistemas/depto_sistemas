<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Producto;
use App\Models\Responsiva;
use App\Models\ResponsivaProducto;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Responsivas extends Controller
{
    public function index()
    {
        $titulo = 'Responsiva';
        $items = Producto::with('categoria')
            ->where('cantidad', '>', 0) // Mostrar solo productos con cantidad > 0
            ->whereHas('categoria', function ($q) {
                $q->whereIn('nombre', ['Pc de Escritorio', 'Laptops', 'Impresoras', 'PC Gaming']); // o el nombre exacto de la categoría
            })->get();
        $colaboradores = Colaborador::orderBy('nombre')->get();

        // Usuarios con rol admin
        $usuariosAdmin = User::where('rol', 'admin')->get();

        return view('modules.responsivas.index', compact(
            'titulo',
            'items',
            'colaboradores',
            'usuariosAdmin'
        ));
    }

    public function create()
    {
        $titulo = 'Crear Responsiva';

        $categoriasPermitidas = ['Pc de Escritorio', 'Laptops', 'Impresoras', 'PC Gaming'];

        $items = Producto::with('categoria')
            ->where('cantidad', '>', 0)
            ->whereHas('categoria', function ($query) use ($categoriasPermitidas) {
                $query->whereIn('nombre', $categoriasPermitidas); // ajusta 'nombre' si tu campo se llama diferente
            })
            ->orderBy('nombre')
            ->get();

        $colaboradores = Colaborador::orderBy('nombre')->get();
        $usuariosAdmin = User::where('rol', 'admin')->get();

        return view('modules.responsivas.create', compact(
            'titulo',
            'items',
            'colaboradores',
            'usuariosAdmin'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|array',
            'producto_id.*' => 'exists:productos,id',
            'cantidad_asignada' => 'required|array',
            'cantidad_asignada.*' => 'integer|min:1',
            'fecha_asignacion' => 'required|date',
            'motivo_entrega' => 'required|string',
            'fecha_entrega' => 'required|date',
            'colaborador_id' => 'required|exists:colaboradores,id',
            'personal_entrego' => 'required|exists:users,id',
            'personal_recibio' => 'required|exists:colaboradores,id',
            'personal_autorizo' => 'required|exists:users,id',
        ]);

        // Verifica disponibilidad de stock
        foreach ($request->producto_id as $index => $productoId) {
            $producto = Producto::findOrFail($productoId);
            $cantidad = $request->cantidad_asignada[$index];
            if ($producto->cantidad < $cantidad) {
                return back()->with('error', "La cantidad solicitada del producto {$producto->nombre} excede el stock disponible.");
            }
        }

        // Crear responsiva
        $colaborador = Colaborador::with(['unidadServicio', 'areaDepartamento'])->findOrFail($request->colaborador_id);

        $responsiva = new Responsiva();
        $responsiva->colaborador_id = $request->colaborador_id;
        $responsiva->usuario_id = auth()->id();
        $responsiva->fecha_asignacion = $request->fecha_asignacion;
        $responsiva->motivo_entrega = $request->motivo_entrega;
        $responsiva->fecha_entrega = $request->fecha_entrega;
        $responsiva->personal_entrego = $request->personal_entrego;
        $responsiva->personal_recibio = $request->personal_recibio;
        $responsiva->personal_autorizo = $request->personal_autorizo;
        $responsiva->unidad = $colaborador->unidadServicio->nombre ?? '-';
        $responsiva->area = $colaborador->areaDepartamento->nombre ?? '-';
        $responsiva->estatus = 'Activa';
        $responsiva->save();

        // Asociar productos
        foreach ($request->producto_id as $index => $productoId) {
            $cantidad = $request->cantidad_asignada[$index];

            ResponsivaProducto::create([
                'responsiva_id' => $responsiva->id,
                'producto_id' => $productoId,
                'cantidad_asignada' => $cantidad,
            ]);

            // Actualizar inventario
            $producto = Producto::findOrFail($productoId);
            $producto->cantidad -= $cantidad;
            $producto->save();
        }

        return redirect()->route('responsivas.ver', ['id' => $responsiva->id, 'origen' => 'responsivas']);
    }

    public function show($id)
    {
        $responsiva = Responsiva::with([
            'producto',
            'colaborador',
            'usuario',
            'entrego',
            'recibio',
            'autorizo'
        ])->findOrFail($id);

        return view('modules.responsivas.show', compact('responsiva'));
    }

    public function edit($id)
    {
        $responsiva = Responsiva::with(['colaborador', 'productos'])->findOrFail($id);
        $colaboradores = Colaborador::orderBy('nombre')->get();
        $usuariosAdmin = User::where('rol', 'admin')->get();
        $items = Producto::all();

        // Detectar si viene de consulta
        $from = request()->query('from', 'responsivas'); // por defecto "responsivas"

        return view('modules.responsivas.edit', compact(
            'responsiva',
            'colaboradores',
            'usuariosAdmin',
            'items',
            'from'
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'colaborador_id' => 'required|exists:colaboradores,id',
            'fecha_asignacion' => 'required|date',
            'motivo_entrega' => 'required|string',
            'fecha_entrega' => 'required|date',
            'personal_entrego' => 'required|exists:users,id',
            'personal_recibio' => 'required|exists:colaboradores,id',
            'personal_autorizo' => 'required|exists:users,id',
            'producto_id' => 'required|array',
            'producto_id.*' => 'required|exists:productos,id',
            'cantidad_asignada' => 'required|array',
            'cantidad_asignada.*' => 'required|integer|min:1',
        ]);

        $responsiva = Responsiva::with('productos')->findOrFail($id);

        // Obtener las cantidades ya asignadas previamente
        $asignacionesAnteriores = $responsiva->productos->pluck('pivot.cantidad_asignada', 'id');

        // Paso 1: Agrupar cantidades por producto
        $productosParaGuardar = [];
        $verificadorStock = [];

        foreach ($request->producto_id as $i => $idProducto) {
            $cantidad = $request->cantidad_asignada[$i];
            $verificadorStock[$idProducto] = ($verificadorStock[$idProducto] ?? 0) + $cantidad;

            $productosParaGuardar[] = [
                'id' => $idProducto,
                'cantidad' => $cantidad
            ];
        }

        // Paso 2: Validar stock tomando en cuenta lo ya asignado
        foreach ($verificadorStock as $idProducto => $cantidadSolicitada) {
            $producto = Producto::findOrFail($idProducto);
            $cantidadAnterior = $asignacionesAnteriores[$idProducto] ?? 0;
            $stockDisponible = $producto->cantidad + $cantidadAnterior;

            if ($cantidadSolicitada > $stockDisponible) {
                return back()->with('error', 'La cantidad total solicitada para "' . $producto->nombre . '" excede el stock disponible.')->withInput();
            }
        }

        // Paso 3: Revertir el stock anterior (restaurar)
        foreach ($responsiva->productos as $productoAnterior) {
            $productoAnterior->cantidad += $productoAnterior->pivot->cantidad_asignada;
            $productoAnterior->save();
        }

        // Paso 4: Eliminar productos previos
        $responsiva->productos()->detach();

        // Paso 5: Actualizar los datos generales
        $responsiva->colaborador_id = $request->colaborador_id;
        $responsiva->fecha_asignacion = $request->fecha_asignacion;
        $responsiva->motivo_entrega = $request->motivo_entrega;
        $responsiva->fecha_entrega = $request->fecha_entrega;
        $responsiva->personal_entrego = $request->personal_entrego;
        $responsiva->personal_recibio = $request->personal_recibio;
        $responsiva->personal_autorizo = $request->personal_autorizo;

        $colaborador = Colaborador::with(['unidadServicio', 'areaDepartamento'])->findOrFail($request->colaborador_id);
        $responsiva->unidad = $colaborador->unidadServicio->nombre ?? '-';
        $responsiva->area = $colaborador->areaDepartamento->nombre ?? '-';
        $responsiva->save();

        // Paso 6: Descontar nuevo stock
        foreach ($verificadorStock as $idProducto => $cantidadFinal) {
            $producto = Producto::findOrFail($idProducto);
            $producto->cantidad -= $cantidadFinal;
            $producto->save();
        }

        // Paso 7: Reasignar productos a la tabla pivote
        foreach ($productosParaGuardar as $p) {
            $responsiva->productos()->attach($p['id'], [
                'cantidad_asignada' => $p['cantidad']
            ]);
        }

        if ($request->has('from') && $request->from === 'consulta') {
            return redirect()->route('responsivas.ver', ['id' => $responsiva->id, 'from' => 'consulta'])
                ->with('success', 'Responsiva actualizada correctamente.');
        }

        return redirect()->route('responsivas.ver', ['id' => $responsiva->id])
            ->with('success', 'Responsiva actualizada correctamente.');
    }




    public function pdf($id)
    {
        $responsiva = Responsiva::with([
            'producto',
            'colaborador',
            'usuario',
            'entrego',
            'recibio',
            'autorizo'
        ])->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('modules.responsivas.pdf', compact('responsiva'));
        return $pdf->download("responsiva_{$id}.pdf");
    }

    public function verPdf($id)
    {
        $responsiva = Responsiva::with([
            'producto',
            'colaborador',
            'usuario',
            'entrego',
            'recibio',
            'autorizo'
        ])->findOrFail($id);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('modules.responsivas.pdf', compact('responsiva'))
            ->stream("responsiva_$id.pdf"); // ← Solo visualizar (no descarga)
    }

    public function ver($id)
    {
        $responsiva = Responsiva::with(['producto', 'colaborador', 'entrego', 'recibio', 'autorizo'])->findOrFail($id);
        return view('modules.responsivas.show', compact('responsiva'));
    }

    public function exportPdf($id)
    {
        $responsiva = Responsiva::with([
            'producto',
            'colaborador',
            'usuario',
            'entrego',
            'recibio',
            'autorizo'
        ])->findOrFail($id);

        return Pdf::loadView('modules.responsivas.pdf', compact('responsiva'))
            ->setPaper('letter', 'portrait')
            ->stream('responsiva_' . $responsiva->id . '.pdf');
    }

    public function createTransporte($id)
    {
        $responsiva = Responsiva::with(['colaborador', 'productos', 'entrego', 'recibio', 'autorizo'])->findOrFail($id);
        $colaboradores = \App\Models\Colaborador::orderBy('nombre')->get(); // ✅ Agregado

        return view('modules.transporte.create', compact('responsiva', 'colaboradores'));
    }


    public function storeTransporte(Request $request, $id)
    {
        $request->validate([
            'nombre_transportista' => 'required|string|max:255',
            'nombre_otro' => 'nullable|string|max:255',
        ]);

        $responsiva = Responsiva::findOrFail($id);
        $transportista = $request->nombre_transportista === 'otro' ? $request->nombre_otro : $request->nombre_transportista;

        // Guardar en la base de datos
        $responsiva->nombre_transportista = $transportista;
        $responsiva->save();

        $pdf = Pdf::loadView('modules.transporte.pdf', [
            'responsiva' => $responsiva,
            'transportista' => $transportista
        ]);

        return $pdf->stream('responsiva_transporte_' . str_pad($responsiva->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function showTransporte($id)
    {
        $responsiva = Responsiva::with(['colaborador.unidadServicio', 'colaborador.areaDepartamento', 'productos', 'entrego', 'recibio', 'autorizo'])
            ->findOrFail($id);

        $transportista = $responsiva->nombre_transportista ?? 'SIN TRANSPORTISTA';

        return view('modules.transporte.show', compact('responsiva', 'transportista'));
    }

    public function editTransporte($id)
    {
        $responsiva = Responsiva::with(['colaborador', 'productos'])->findOrFail($id);
        $colaboradores = Colaborador::orderBy('nombre')->get();

        $transportista = $responsiva->nombre_transportista ?? '';

        return view('modules.transporte.edit', compact('responsiva', 'colaboradores', 'transportista'));
    }

    public function updateTransporte(Request $request, $id)
    {
        $request->validate([
            'nombre_transportista' => 'required|string|max:255',
            'nombre_otro' => 'nullable|string|max:255',
        ]);

        $responsiva = Responsiva::findOrFail($id);
        $transportista = $request->nombre_transportista === 'otro'
            ? $request->nombre_otro
            : $request->nombre_transportista;

        $responsiva->nombre_transportista = $transportista;
        $responsiva->save();

        return redirect()
            ->route('responsivas.transporte.show', $responsiva->id)
            ->with('success', 'Transportista actualizado correctamente.');
    }

    public function firmar(Request $request, $id)
    {
        $request->validate([
            'firma_recibio' => 'required|string',
        ]);

        $responsiva = Responsiva::findOrFail($id);

        // Si ya hay una firma previa, elimínala del disco
        if ($responsiva->firma_recibio && Storage::exists('public/' . $responsiva->firma_recibio)) {
            Storage::delete('public/' . $responsiva->firma_recibio);
        }

        // Procesar imagen base64
        $firmaData = $request->input('firma_recibio');
        $image = str_replace('data:image/png;base64,', '', $firmaData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'firma_recibio_' . time() . '.png';

        // Guarda la nueva firma
        Storage::put("public/firmas/$imageName", base64_decode($image));

        // Actualiza la ruta en base de datos
        $responsiva->firma_recibio = "firmas/$imageName";
        $responsiva->save();

        return redirect()->route('responsivas.show', $responsiva->id)
            ->with('success', 'Firma guardada correctamente.');
    }

    public function firmarTransportista(Request $request, $id)
    {
        $request->validate([
            'firma_transportista' => 'required|string',
        ]);

        $responsiva = Responsiva::findOrFail($id);

        // Guardar firma como imagen en storage
        $firmaData = $request->firma_transportista;
        $firma = str_replace('data:image/png;base64,', '', $firmaData);
        $firma = str_replace(' ', '+', $firma);
        $firmaNombre = 'firmas_transportistas/firma_' . $responsiva->id . '_' . time() . '.png';

        Storage::disk('public')->put($firmaNombre, base64_decode($firma));

        // Guardar nombre de archivo en la base de datos
        $responsiva->firma_transportista = $firmaNombre;
        $responsiva->save();

        return redirect()->back()->with('success', 'Firma del transportista guardada correctamente.');
    }
}
