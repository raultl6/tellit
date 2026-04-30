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

    // 3. Mostrar formulario de Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 4. Procesar Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'], // Busca si el email existe
            'password' => ['required'], // Busca si la contraseña coincide con la encriptada en la baase de datos
        ]);

        if (Auth::attempt($credentials)) {
            // Verificar si está baneado
            if (Auth::user()->is_banned) {
                Auth::logout();
                return back()->with('error', 'Tu cuenta ha sido suspendida. Contacta a soporte para más información.');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // 5. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // 6. Perfil de Usuario
    public function profile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    // 7. Mostrar formulario para editar perfil
    public function editProfile()
    {
        return view('auth.edit-profile', ['user' => Auth::user()]);
    }

    // 8. Actualizar perfil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Si el usuario rellenó el campo de contraseña, la actualizamos
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Guardar la imagen en storage/app/public/avatars
            $rutaImagen = $request->file('avatar')->store('avatars', 'public');
            // Generar la URL pública
            $user->avatar = asset('storage/' . $rutaImagen);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente.');
    }
}