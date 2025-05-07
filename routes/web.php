<?php

use App\Http\Controllers\Areas_Departamentos;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categorias;
use App\Http\Controllers\Colaboradores;
use App\Http\Controllers\ConsultaResponsiva;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Empresas;
use App\Http\Controllers\Entradas;
use App\Http\Controllers\Productos;
use App\Http\Controllers\Proveedores;
use App\Http\Controllers\Reportes_productos;
use App\Http\Controllers\Responsivas;
use App\Http\Controllers\Unidades_Servicio;
use App\Http\Controllers\Usuarios;
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
Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);

//Login al Sistema
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');

//Si no estas logueado no puedes dirigirte a Home
Route::middleware("auth")->group(function () {
    Route::get('/home', [Dashboard::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::prefix('responsiva')->middleware('auth')->group(function () {
    Route::get('/nueva-responsiva', [Responsivas::class, 'index'])->name('responsivas.index');
    Route::post('/responsivas/store', [Responsivas::class, 'store'])->name('responsivas.store');
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
    Route::get('/cambiar-estado/{id}/{estado}', [Productos::class, 'estado'])->name('productos.estado');
    Route::post('/productos/cambiar-imagen', [Productos::class, 'cambiarImagen'])->name('productos.cambiar.imagen');
});

//Rutas de Reportes - CRUD
route::prefix('reportes_productos')->middleware('auth')->group(function () {
    Route::get('/', [Reportes_productos::class, 'index'])->name('reportes_productos');
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

//Rutas de Colaboradores - CRUD
Route::prefix('colaboradores')->middleware('auth')->group(function () {
    Route::get('/', [Colaboradores::class, 'index'])->name('colaboradores');
    Route::get('/create', [Colaboradores::class, 'create'])->name('colaboradores.create');
    Route::post('/store', [Colaboradores::class, 'store'])->name('colaboradores.store');
    Route::get('/{id}/edit', [Colaboradores::class, 'edit'])->name('colaboradores.edit');
    Route::put('/{id}/update', [Colaboradores::class, 'update'])->name('colaboradores.update');
    Route::get('/{id}/show', [Colaboradores::class, 'show'])->name('colaboradores.show');
    Route::delete('/{id}', [Colaboradores::class, 'destroy'])->name('colaboradores.destroy');

    Route::get('/api/unidades/{empresaId}', [Colaboradores::class, 'getUnidades']);
    Route::get('/api/areas/{unidadId}', [Colaboradores::class, 'getAreas']);
});

//Rutas de Usuarios - CRUD
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

//Rutas de Entradas - CRUD
route::prefix('entradas')->middleware('auth')->group(function () {
    Route::get('/', [Entradas::class, 'index'])->name('entradas');
    Route::get('/create/{id_producto}', [Entradas::class, 'create'])->name('entradas.create');
    Route::post('/store', [Entradas::class, 'store'])->name('entradas.store');
    Route::get('/edit/{id}', [Entradas::class, 'edit'])->name('entradas.edit');
    route::put('/update/{id}', [Entradas::class, 'update'])->name('entradas.update');
    Route::get('/show/{id}', [Entradas::class, 'show'])->name('entradas.show');
    Route::delete('/destroy/{id}', [Entradas::class, 'destroy'])->name('entradas.destroy');
});

// Rutas de Empresas - CRUD
Route::prefix('empresas')->middleware('auth')->group(function () {
    Route::get('/', [Empresas::class, 'index'])->name('empresas');
    Route::get('/create', [Empresas::class, 'create'])->name('empresas.create');
    Route::post('/store', [Empresas::class, 'store'])->name('empresas.store');
    Route::get('/show/{id}', [Empresas::class, 'show'])->name('empresas.show');
    Route::delete('/destroy/{id}', [Empresas::class, 'destroy'])->name('empresas.destroy');
    Route::get('/edit/{id}', [Empresas::class, 'edit'])->name('empresas.edit');
    Route::put('/update/{id}', [Empresas::class, 'update'])->name('empresas.update');
});

// Rutas de Unidades de Servicio - CRUD
Route::prefix('unidades')->middleware('auth')->group(function () {
    Route::get('/', [Unidades_Servicio::class, 'index'])->name('unidades');
    Route::get('/create', [Unidades_Servicio::class, 'create'])->name('unidades.create');
    Route::post('/store', [Unidades_Servicio::class, 'store'])->name('unidades.store');
    Route::get('/show/{id}', [Unidades_Servicio::class, 'show'])->name('unidades.show');
    Route::delete('/destroy/{id}', [Unidades_Servicio::class, 'destroy'])->name('unidades.destroy');
    Route::get('/edit/{id}', [Unidades_Servicio::class, 'edit'])->name('unidades.edit');
    Route::put('/update/{id}', [Unidades_Servicio::class, 'update'])->name('unidades.update');
});

// Rutas de Áreas / Departamentos - CRUD
Route::prefix('areas')->middleware('auth')->group(function () {
    Route::get('/', [Areas_Departamentos::class, 'index'])->name('areas');
    Route::get('/create', [Areas_Departamentos::class, 'create'])->name('areas.create');
    Route::post('/store', [Areas_Departamentos::class, 'store'])->name('areas.store');
    Route::get('/show/{id}', [Areas_Departamentos::class, 'show'])->name('areas.show');
    Route::delete('/destroy/{id}', [Areas_Departamentos::class, 'destroy'])->name('areas.destroy');
    Route::get('/edit/{id}', [Areas_Departamentos::class, 'edit'])->name('areas.edit');
    Route::put('/update/{id}', [Areas_Departamentos::class, 'update'])->name('areas.update');
});
