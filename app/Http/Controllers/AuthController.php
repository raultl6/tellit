<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Mostrar el formulario de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // 2. Procesar el registro (Guardar usuario)
    public function register(Request $request)
    {
        // Validamos que los datos estén bien
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Email único
            'password' => 'required|string|min:8|confirmed', // "confirmed" busca el campo password_confirmation
        ]);

        // Creamos el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptamos la contraseña
            'avatar' => 'https://ui-avatars.com/api/?name=' . $request->name, // Avatar automático con sus iniciales
        ]);

        // Iniciamos sesión automáticamente
        Auth::login($user);

        // Lo mandamos a la portada
        return redirect()->route('home')->with('success', '¡Bienvenido a Tellit!');
    }
}