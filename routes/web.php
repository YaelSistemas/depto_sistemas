<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categorias;
use App\Http\Controllers\Colaboradores;
use App\Http\Controllers\ConsultaResponsiva;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Productos;
use App\Http\Controllers\Proveedores;
use App\Http\Controllers\Responsiva;
use App\Http\Controllers\Usuarios;
use App\Models\Categoria;
use App\Models\Proveedor;
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

//Crear un Usuario Admin, solo usar una vez
//Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);

//Login al Sistema
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');

//Si no estas logueado no puedes dirigirte a Home
Route::middleware("auth")->group(function () {
    Route::get('/home', [Dashboard::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


route::prefix('responsiva')->middleware('auth')->group(function () {
    route::get('/nueva-responsiva', [Responsiva::class, 'index'])->name('responsiva-nueva');
});

route::prefix('consulta_responsiva')->middleware('auth')->group(function () {
    route::get('/consulta-responsiva', [ConsultaResponsiva::class, 'index'])->name('consulta-responsiva');
});

//Rutas de Categorias - CRUD
route::prefix('categorias')->middleware('auth')->group(function () {
    Route::get('/', [Categorias::class, 'index'])->name('categorias');
    Route::get('/create', [Categorias::class, 'create'])->name('categorias.create');
    Route::post('/store', [Categorias::class, 'store'])->name('categorias.store');
    Route::get('/show/{id}', [Categorias::class, 'show'])->name('categorias.show');
    Route::delete('/destroy/{id}', [Categorias::class, 'destroy'])->name('categorias.destroy');
    Route::get('/edit/{id}', [Categorias::class, 'edit'])->name('categorias.edit');
    route::put('/update/{id}', [Categorias::class, 'update'])->name('categorias.update');
});

//Rutas de Productos - CRUD
route::prefix('productos')->middleware('auth')->group(function () {
    Route::get('/', [Productos::class, 'index'])->name('productos');
    Route::get('/create', [Productos::class, 'create'])->name('productos.create');
    Route::post('/store', [Productos::class, 'store'])->name('productos.store');
    Route::get('/show/{id}', [Productos::class, 'show'])->name('productos.show');
    Route::delete('/destroy/{id}', [Productos::class, 'destroy'])->name('productos.destroy');
    Route::get('/edit/{id}', [Productos::class, 'edit'])->name('productos.edit');
    route::put('/update/{id}', [Productos::class, 'update'])->name('productos.update');
});

//Rutas de Proveedores - CRUD
route::prefix('proveedores')->middleware('auth')->group(function () {
    Route::get('/', [Proveedores::class, 'index'])->name('proveedores');
    Route::get('/create', [Proveedores::class, 'create'])->name('proveedores.create');
    Route::post('/store', [Proveedores::class, 'store'])->name('proveedores.store');
    Route::get('/show/{id}', [Proveedores::class, 'show'])->name('proveedores.show');
    Route::delete('/destroy/{id}', [Proveedores::class, 'destroy'])->name('proveedores.destroy');
    Route::get('/edit/{id}', [Proveedores::class, 'edit'])->name('proveedores.edit');
    route::put('/update/{id}', [Proveedores::class, 'update'])->name('proveedores.update');
});

route::prefix('colaboradores')->middleware('auth')->group(function () {
    Route::get('/', [Colaboradores::class, 'index'])->name('colaboradores');
});

route::prefix('usuarios')->middleware('auth')->group(function () {
    Route::get('/', [Usuarios::class, 'index'])->name('usuarios');
    Route::get('/create', [Usuarios::class, 'create'])->name('usuarios.create');
    Route::post('/store', [Usuarios::class, 'store'])->name('usuarios.store');
    Route::get('/edit/{id}', [Usuarios::class, 'edit'])->name('usuarios.edit');
    route::put('/update/{id}', [Usuarios::class, 'update'])->name('usuarios.update');
    Route::get('/tbody', [Usuarios::class, 'tbody'])->name('usuarios.tbody');
    Route::get('/cambiar-estado/{id}/{estado}', [Usuarios::class, 'estado'])->name('usuarios.estado');
    Route::get('/cambiar-password/{id}/{password}', [Usuarios::class, 'cambio_password'])->name('usuarios.password');
});
