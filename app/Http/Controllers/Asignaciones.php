<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ResponsivaProducto;
use Illuminate\Http\Request;

class Asignaciones extends Controller
{
    public function index()
    {
        $asignaciones = ResponsivaProducto::with([
            'producto.categoria',
            'producto.proveedor',
            'producto',
            'responsiva.colaborador.empresa',
            'responsiva.colaborador.unidad'
        ])->get();

        return view('modules.asignaciones.index', compact('asignaciones'));
    }
}
