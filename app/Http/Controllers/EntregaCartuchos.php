<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\EntregaCartucho;
use App\Models\Producto;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EntregaCartuchos extends Controller
{
    public function index()
    {
        $titulo = 'Entrega de Cartuchos';

        $items = Producto::with('categoria')
            ->whereHas('categoria', function ($query) {
                $query->whereIn('nombre', ['Cartucho', 'Toner', 'Tinta']);
            })
            ->where('cantidad', '>', 0)
            ->get();

        $colaboradores = Colaborador::orderBy('nombre')->get();
        $usuariosAdmin = User::where('rol', 'admin')->get();

        return view('modules.entrega_cartuchos.index', compact(
            'titulo',
            'items',
            'colaboradores',
            'usuariosAdmin'
        ));
    }

    public function create()
    {
        $titulo = 'Crear Entrega de Cartuchos';

        $items = Producto::with('categoria')
            ->whereHas('categoria', function ($q) {
                $q->whereIn('nombre', ['Cartucho', 'Toner', 'Tinta']);
            })
            ->where('cantidad', '>', 0)
            ->get();

        $colaboradores = Colaborador::orderBy('nombre')->get();
        $usuariosAdmin = User::where('rol', 'admin')->get();

        return view('modules.entrega_cartuchos.create', compact('titulo', 'items', 'colaboradores', 'usuariosAdmin'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'colaborador_id'      => 'required|exists:colaboradores,id',
            'fecha_asignacion'    => 'required|date',
            'fecha_entrega'       => 'required|date',
            'personal_entrego'    => 'required|exists:users,id',
            'personal_recibio'    => 'required|exists:colaboradores,id',
            'producto_id'         => 'required|array',
            'producto_id.*'       => 'required|exists:productos,id',
            'cantidad_asignada'   => 'required|array',
            'cantidad_asignada.*' => 'required|integer|min:1',
        ]);

        $verificadorStock = [];

        foreach ($request->producto_id as $i => $idProducto) {
            $cantidad = $request->cantidad_asignada[$i];
            $verificadorStock[$idProducto] = ($verificadorStock[$idProducto] ?? 0) + $cantidad;
        }

        foreach ($verificadorStock as $idProducto => $cantidadTotal) {
            $producto = Producto::findOrFail($idProducto);
            if ($producto->cantidad < $cantidadTotal) {
                return back()->with('error', 'La cantidad solicitada para "' . $producto->nombre . '" excede el stock disponible.');
            }
        }

        $entrega = new EntregaCartucho();
        $entrega->colaborador_id    = $request->colaborador_id;
        $entrega->fecha_asignacion  = $request->fecha_asignacion;
        $entrega->fecha_entrega     = $request->fecha_entrega;
        $entrega->personal_entrego  = $request->personal_entrego;
        $entrega->personal_recibio  = $request->personal_recibio;

        $colaborador = Colaborador::with(['unidadServicio', 'areaDepartamento'])->findOrFail($request->colaborador_id);
        $entrega->unidad = $colaborador->unidadServicio->nombre ?? '-';
        $entrega->area   = $colaborador->areaDepartamento->nombre ?? '-';
        $entrega->save();

        foreach ($request->producto_id as $i => $idProducto) {
            $cantidad = $request->cantidad_asignada[$i];
            $producto = Producto::findOrFail($idProducto);
            $producto->cantidad -= $cantidad;
            $producto->save();

            $entrega->productos()->attach($idProducto, [
                'cantidad_asignada' => $cantidad
            ]);
        }

        return redirect()->route('entrega_cartuchos.show', $entrega->id)
            ->with('success', 'Entrega registrada correctamente.');
    }

    public function show($id)
    {
        $entrega = EntregaCartucho::with(['colaborador', 'productos', 'entrego', 'recibio', 'autorizo'])->findOrFail($id);

        return view('modules.entrega_cartuchos.show', compact('entrega'));
    }

    public function edit($id)
    {
        $entrega = EntregaCartucho::with('productos')->findOrFail($id);
        $titulo = 'Editar Entrega de Cartuchos';
        $items = Producto::with('categoria')
            ->whereHas('categoria', fn($q) => $q->where('nombre', 'Cartucho'))
            ->where('cantidad', '>', 0)
            ->get();
        $colaboradores = Colaborador::orderBy('nombre')->get();
        $usuariosAdmin = User::where('rol', 'admin')->get();

        return view('modules.entrega_cartuchos.edit', compact('titulo', 'entrega', 'items', 'colaboradores', 'usuariosAdmin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'colaborador_id'      => 'required|exists:colaboradores,id',
            'fecha_asignacion'    => 'required|date',
            'fecha_entrega'       => 'required|date',
            'personal_entrego'    => 'required|exists:users,id',
            'personal_recibio'    => 'required|exists:colaboradores,id',
            'producto_id'         => 'required|array',
            'producto_id.*'       => 'required|exists:productos,id',
            'cantidad_asignada'   => 'required|array',
            'cantidad_asignada.*' => 'required|integer|min:1',
        ]);

        $entrega = EntregaCartucho::with('productos')->findOrFail($id);

        // ✅ Revertir correctamente stock anterior agrupado
        $stockAnterior = [];
        foreach ($entrega->productos as $p) {
            $stockAnterior[$p->id] = ($stockAnterior[$p->id] ?? 0) + $p->pivot->cantidad_asignada;
        }

        foreach ($stockAnterior as $idProducto => $cantidad) {
            $producto = Producto::find($idProducto);
            if ($producto) {
                $producto->cantidad += $cantidad;
                $producto->save();
            }
        }

        $entrega->productos()->detach();

        // Actualizar datos generales
        $entrega->colaborador_id    = $request->colaborador_id;
        $entrega->fecha_asignacion  = $request->fecha_asignacion;
        $entrega->fecha_entrega     = $request->fecha_entrega;
        $entrega->personal_entrego  = $request->personal_entrego;
        $entrega->personal_recibio  = $request->personal_recibio;

        $colaborador = Colaborador::with(['unidadServicio', 'areaDepartamento'])->findOrFail($request->colaborador_id);
        $entrega->unidad = $colaborador->unidadServicio->nombre ?? '-';
        $entrega->area   = $colaborador->areaDepartamento->nombre ?? '-';
        $entrega->save();

        // Verificación de stock nuevo
        $verificadorStock = [];
        foreach ($request->producto_id as $i => $idProducto) {
            $cantidad = $request->cantidad_asignada[$i];
            $verificadorStock[$idProducto] = ($verificadorStock[$idProducto] ?? 0) + $cantidad;
        }

        foreach ($verificadorStock as $idProducto => $cantidadTotal) {
            $producto = Producto::findOrFail($idProducto);
            if ($producto->cantidad < $cantidadTotal) {
                return back()->with('error', 'La cantidad total solicitada para "' . $producto->nombre . '" excede el stock disponible.');
            }
        }

        // Asignar productos y restar stock
        foreach ($request->producto_id as $i => $idProducto) {
            $cantidad = $request->cantidad_asignada[$i];
            $producto = Producto::findOrFail($idProducto);
            $producto->cantidad -= $cantidad;
            $producto->save();

            $entrega->productos()->attach($idProducto, [
                'cantidad_asignada' => $cantidad
            ]);
        }

        return redirect()
            ->route('entrega_cartuchos.show', ['id' => $entrega->id, 'from' => $request->input('from')])
            ->with('success', 'Entrega actualizada correctamente.');
    }


    public function pdf($id)
    {
        $entrega = EntregaCartucho::with(['colaborador', 'productos', 'entrego', 'recibio'])->findOrFail($id);

        $pdf = Pdf::loadView('modules.entrega_cartuchos.pdf', compact('entrega'));
        return $pdf->stream('entrega_cartucho_' . str_pad($entrega->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }
}
