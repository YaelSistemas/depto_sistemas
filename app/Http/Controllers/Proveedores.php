<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class Proveedores extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Proveedores';
        $items = Proveedor::all();
        return view('modules.proveedores.index', compact('items', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Agregar Proveedor';
        return view('modules.proveedores.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Proveedor();
            $item->nombre = $request->nombre;
            $item->telefono = $request->telefono;
            $item->email = $request->email;
            $item->ubicacion = $request->ubicacion;
            $item->sitio_web = $request->sitio_web;
            $item->notas = $request->notas;
            $item->save();
            return to_route('proveedores')->with("success", "Proveedor Agregado con Exito");
        } catch (\Throwable $th) {
            return to_route('proveedores')->with("error", "Fallo al Agregar Proveedor" . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = "Eliminar un Proveedor";
        $item = Proveedor::find($id);
        return view("modules.proveedores.show", compact('item', 'titulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = "Editar Proveedor";
        $item = Proveedor::find($id);
        return view('modules.proveedores.edit', compact('item', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Proveedor::find($id);
            $item->nombre = $request->nombre;
            $item->telefono = $request->telefono;
            $item->email = $request->email;
            $item->ubicacion = $request->ubicacion;
            $item->sitio_web = $request->sitio_web;
            $item->notas = $request->notas;
            $item->save();
            return to_route('proveedores')->with('success', 'Actualizado con Exito');
        } catch (\Throwable $th) {
            return to_route('proveedores')->with('error', 'No se pudo Actualizar' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Proveedor::find($id);
            $item->delete();
            return to_route('proveedores')->with('success', 'Proveedor Eliminado con Exito');
        } catch (\Throwable $th) {
            return to_route('proveedores')->with('error', 'Fallo al Eliminar', $th->getMessage());
        }
    }
}
