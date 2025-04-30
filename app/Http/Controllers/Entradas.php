<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Entradas extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $titulo = 'Entrada de Productos';
        $item = Producto::find($id);
        return view('modules.entradas.create', compact('titulo', 'item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Entrada();
            $item->user_id = Auth::user()->id;
            $item->producto_id = $request->id;
            $item->cantidad = $request->cantidad;
            $item->precio = $request->precio;
            if ($item->save()) {
                $item = Producto::find($request->id);
                $item->cantidad = ($item->cantidad + $request->cantidad);
                $item->precio = $request->precio;
                $item->save();
            }
            return to_route('productos')->with('success', 'Entrada exitosa');
        } catch (\Throwable $th) {
            return to_route('productos')->with('error', 'No pudo Entrar' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Si ya hicimos una salida con este producto, no seria buena idea actualizarlo
        try {
            $cantidad_anterior = 0;
            $item = Entrada::find($id);
            $cantidad_anterior = $item->cantidad;
            $item->cantidad = $request->cantidad;
            $item->precio = $request->precio;

            if ($item->save()) {
                $item = Producto::find($request->producto_id);
                //Cantidad = cantidad actual de producto menos la cantidad anterior de compra
                //cantidad = cantidad + nueva cantidad
                $cantidad_anterior = $item->cantidad - $cantidad_anterior;
                $item->cantidad = $cantidad_anterior + $request->cantidad;
                $item->save();
                return to_route('entradas')->with('success', 'Entrada Actualizada con Exito');
            }
        } catch (\Throwable $th) {
            return to_route('entradas')->with('error', 'No se pudo Actualizar la Entrada' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $item = Entrada::find($id);
            $cantidad_compra = $item->cantidad;
            if ($item->delete()) {
                $item = Producto::find($request->producto_id);
                $item->cantidad = $item->cantidad - $cantidad_compra;
                $item->save();
                return to_route('entradas')->with('success', 'Entrada Eliminada con Exito');
            } else {
                return to_route('entradas')->with('error', 'La Entrada no se pudo Eliminar');
            }
        } catch (\Throwable $th) {
            return to_route('entradas')->with('error', 'No se pudo Eliminar la Entrada' . $th->getMessage());
        }
    }
}
