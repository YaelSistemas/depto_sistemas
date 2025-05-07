<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Producto;
use App\Models\Responsiva;
use App\Models\User;
use Illuminate\Http\Request;

class Responsivas extends Controller
{
    public function index()
    {
        $titulo = 'Responsiva';
        $items = Producto::all();
        $colaboradores = Colaborador::orderBy('nombre')->get();

        return view('modules.responsivas.index', compact('titulo', 'items', 'colaboradores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'colaborador_id' => 'required|exists:colaboradores,id',
            'cantidad_asignada' => 'required|integer',
            'fecha_asignacion' => 'required|date',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($producto->cantidad < $request->cantidad_asignada) {
            return back()->with('error', 'La cantidad solicitada excede el stock disponible.');
        }

        $responsiva = new Responsiva();
        $responsiva->producto_id = $request->producto_id;
        $responsiva->colaborador_id = $request->colaborador_id;
        $responsiva->usuario_id = auth()->id(); // <- Línea agregada
        $responsiva->cantidad_asignada = $request->cantidad_asignada;
        $responsiva->fecha_asignacion = $request->fecha_asignacion;
        $responsiva->estatus = 'Activa';
        $responsiva->save();

        $producto->cantidad -= $request->cantidad_asignada;
        $producto->save();

        return redirect()->route('responsivas.index')->with('success', 'Responsiva creada correctamente.');
    }
}
