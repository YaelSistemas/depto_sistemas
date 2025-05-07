<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Empresa;
use App\Models\UnidadServicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Unidades_Servicio extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Administrar Unidades de Servicio';
        $items = UnidadServicio::with(['empresa', 'colaborador'])->get();
        return view('modules.unidades_servicio.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Unidad de Servicio';
        $empresas = Empresa::all();
        $colaboradores = Colaborador::all();
        return view('modules.unidades_servicio.create', compact('titulo', 'empresas', 'colaboradores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new UnidadServicio();
            $item->user_id = Auth::user()->id;
            $item->nombre = $request->nombre;
            $item->empresa_id = $request->empresa_id;
            $item->colaborador_id = $request->colaborador_id;
            $item->save();
            return to_route('unidades')->with('success', 'Unidad de Servicio Agregada');
        } catch (Exception $e) {
            return to_route('unidades')->with('error', 'No se pudo Guardar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar Unidad de Servicio';
        $item = UnidadServicio::with(['empresa', 'colaborador'])->find($id);
        return view('modules.unidades_servicio.show', compact('item', 'titulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Unidad de Servicio';
        $item = UnidadServicio::find($id);
        $empresas = Empresa::all();
        $colaboradores = Colaborador::all();
        return view('modules.unidades_servicio.edit', compact('item', 'titulo', 'empresas', 'colaboradores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = UnidadServicio::find($id);
            $item->nombre = $request->nombre;
            $item->empresa_id = $request->empresa_id;
            $item->colaborador_id = $request->colaborador_id;
            $item->save();
            return to_route('unidades')->with('success', 'Unidad de Servicio Actualizada');
        } catch (Exception $e) {
            return to_route('unidades')->with('error', 'No se pudo Actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = UnidadServicio::find($id);
            $item->delete();
            return to_route('unidades')->with('success', 'Unidad de Servicio Eliminada');
        } catch (Exception $e) {
            return to_route('unidades')->with('error', 'No se pudo Eliminar: ' . $e->getMessage());
        }
    }
}
