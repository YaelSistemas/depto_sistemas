<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultaResponsiva;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Responsiva;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/home', [Dashboard::class, 'index'])->name('home');

route::prefix('responsiva')->group(function () {
    route::get('/nueva-responsiva', [Responsiva::class, 'index'])->name('responsiva-nueva');
});

route::prefix('consulta_responsiva')->group(function () {
    route::get('/consulta-responsiva', [ConsultaResponsiva::class, 'index'])->name('consulta-responsiva');
});
