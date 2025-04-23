<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Responsiva extends Controller
{
    public function index()
    {
        return view('modules.responsiva.index');
    }
}
