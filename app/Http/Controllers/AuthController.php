<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $titulo = "Login";
        return view("modules.auth.login", compact("titulo"));
    }

    public function logear(Request $request)
    {
        //Validar datos de las credenciales
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //buscar el email
        $user = User::where('email', $request->email)->first();

        //Validar Usuario y Contraseña
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credencial Incorrecta'])->withInput();
        }

        //El Usuario este Activo
        if (!$user->activo) {
            return back()->withErrors(['email' => 'Tu cuenta esta inactiva!']);
        }

        //Crear la Sesion de Usuario
        Auth::login($user);
        $request->session()->regenerate();

        return to_route('home');
    }

    public function crearAdmin()
    {
        //Crear Directamente un Admin
        User::create([
            'name' => 'Sistemas',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'activo' => true,
            'rol' => 'admin'
        ]);

        return "Admin creado con exito!!";
    }

    //Logout, cierra sesion y regresa al Login
    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
