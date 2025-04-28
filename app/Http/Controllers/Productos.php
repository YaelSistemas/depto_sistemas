<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->join('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
            ->get();
        return view('modules.productos.index', compact('items', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Producto';
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('modules.productos.create', compact('titulo', 'categorias', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Producto();
            $item->user_id = Auth::user()->id;
            $item->categoria_id = $request->categoria_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->marca = $request->marca;
            $item->modelo = $request->modelo;
            $item->no_serie = $request->no_serie;
            $item->save();
            return to_route('productos')->with('success', 'Producto Creado Exitosamente');
        } catch (\Throwable $th) {
            return to_route('productos')->with('success', 'Fallo al Crear Producto', $th->getMessage());
        }
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
        return view('modules.productos.edit', compact('item', 'titulo', 'categorias', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Producto::find($id);
            $item->categoria_id = $request->categoria_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->marca = $request->marca;
            $item->modelo = $request->modelo;
            $item->no_serie = $request->no_serie;
            $item->save();
            return to_route('productos')->with('success', 'Producto Actualizado Exitosamente');
        } catch (\Throwable $th) {
            return to_route('productos')->with('success', 'Fallo al Actualizar Producto', $th->getMessage());
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
}
