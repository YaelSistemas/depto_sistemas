<?php

namespace App\Http\Controllers;

use App\Models\EntregaCartucho;
use Illuminate\Http\Request;

class ConsultaEntregaCartuchos extends Controller
{
    public function index()
    {
        $titulo = 'Consulta Entrega de Cartuchos';

        $entregas = EntregaCartucho::with(['productos', 'colaborador', 'recibio', 'entrego'])->get();

        return view('modules.consulta_entrega_cartuchos.index', compact('titulo', 'entregas'));
    }
}
