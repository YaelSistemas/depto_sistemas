<?php

namespace App\Http\Controllers;

use App\Models\AreaDepartamento;
use App\Models\Empresa;
use App\Models\UnidadServicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Areas_Departamentos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Administrar Áreas / Departamentos';
        $items = AreaDepartamento::with(['empresa', 'unidad'])->get();
        return view('modules.area_departamentos.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Área / Departamento';
        $unidades = UnidadServicio::with('empresa')->get();
        $empresas = Empresa::all();
        return view('modules.area_departamentos.create', compact('titulo', 'empresas', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new AreaDepartamento();
            $item->user_id = Auth::user()->id;
            $item->empresa_id = $request->empresa_id;
            $item->unidad_servicio_id = $request->unidad_servicio_id;
            $item->nombre = $request->nombre;
            $item->save();
            return to_route('areas')->with('success', 'Área / Departamento Agregado');
        } catch (Exception $e) {
            return to_route('areas')->with('error', 'No se pudo Guardar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar Área / Departamento';
        $item = AreaDepartamento::with(['empresa', 'unidad'])->find($id);
        return view('modules.area_departamentos.show', compact('item', 'titulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Área / Departamento';
        $item = AreaDepartamento::find($id);
        $empresas = Empresa::all();
        $unidades = UnidadServicio::all();
        return view('modules.area_departamentos.edit', compact('item', 'titulo', 'empresas', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = AreaDepartamento::find($id);
            $item->nombre = $request->nombre;
            $item->empresa_id = $request->empresa_id;
            $item->unidad_servicio_id = $request->unidad_servicio_id;
            $item->save();
            return to_route('areas')->with('success', 'Área / Departamento Actualizado');
        } catch (Exception $e) {
            return to_route('areas')->with('error', 'No se pudo Actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = AreaDepartamento::find($id);
            $item->delete();
            return to_route('areas')->with('success', 'Área / Departamento Eliminado');
        } catch (Exception $e) {
            return to_route('areas')->with('error', 'No se pudo Eliminar: ' . $e->getMessage());
        }
    }
}
