<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $ultimasEntradas = Entrada::with(['producto', 'usuario'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $productosCriticos = Producto::whereIn('cantidad', [0, 1])
            ->whereHas('categoria', function ($query) {
                $query->whereIn('nombre', ['Tinta', 'Cartucho', 'Toner']);
            })
            ->with('categoria')
            ->get();

        return view('modules.dashboard.home', compact('ultimasEntradas', 'productosCriticos'));
    }
}
