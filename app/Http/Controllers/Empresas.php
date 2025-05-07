<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Empresas extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Administrar Empresas';
        $items = Empresa::all();
        return view('modules.empresas.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Empresa';
        return view('modules.empresas.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Empresa();
            $item->user_id = Auth::user()->id;
            $item->nombre = $request->nombre;
            $item->save();
            return to_route('empresas')->with('success', 'Empresa Agregada');
        } catch (Exception $e) {
            return to_route('empresas')->with('error', 'No se pudo Guardar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar Empresa';
        $item = Empresa::find($id);
        return view('modules.empresas.show', compact('item', 'titulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Empresa';
        $item = Empresa::find($id);
        return view('modules.empresas.edit', compact('item', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Empresa::find($id);
            $item->nombre = $request->nombre;
            $item->save();
            return to_route('empresas')->with('success', 'Empresa Actualizada');
        } catch (Exception $e) {
            return to_route('empresas')->with('error', 'No se pudo Actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Empresa::find($id);
            $item->delete();
            return to_route('empresas')->with('success', 'Empresa Eliminada');
        } catch (Exception $e) {
            return to_route('empresas')->with('error', 'No se pudo Eliminar: ' . $e->getMessage());
        }
    }
}
