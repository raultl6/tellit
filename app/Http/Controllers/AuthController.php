<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra el formulario de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesa el registro de un nuevo usuario
    public function register(Request $request)
    {
        // Se validan los datos recibidos del formulario antes de guardar nada.
        // 'unique:users' comprueba que no exista otro usuario con ese email.
        // 'confirmed' exige que exista un campo "password_confirmation" con el mismo valor.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Se crea el usuario en la base de datos.
        // Hash::make() cifra la contraseña para no almacenarla en texto plano.
        // El avatar se genera automáticamente a partir del nombre usando un servicio externo.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'https://ui-avatars.com/api/?name=' . $request->name,
        ]);

        // Se inicia sesión de forma automática tras el registro
        Auth::login($user);

        // Se redirige al inicio con un mensaje de bienvenida almacenado en la sesión
        return redirect()->route('home')->with('success', '¡Bienvenido a Tellit!');
    }

    // Muestra el formulario de inicio de sesión
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesa el inicio de sesión
    public function login(Request $request)
    {
        // Se validan los campos obligatorios
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt() comprueba si el email y la contraseña coinciden con un registro en la base de datos
        if (Auth::attempt($credentials)) {
            // Si el usuario está baneado, se cierra la sesión y se le informa
            if (Auth::user()->is_banned) {
                Auth::logout();
                return back()->with('error', 'Tu cuenta ha sido suspendida. Contacta a soporte para más información.');
            }

            // Se regenera la sesión por seguridad para prevenir ataques de fijación de sesión
            $request->session()->regenerate();

            // intended() redirige a la URL que el usuario intentaba visitar antes de ser redirigido al login
            return redirect()->intended(route('home'));
        }

        // Si las credenciales no coinciden, se devuelve un error al formulario
        // onlyInput('email') mantiene el email escrito para que no tenga que reescribirlo
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Cierra la sesión del usuario
    public function logout(Request $request)
    {
        Auth::logout();

        // Se invalida la sesión actual y se regenera el token CSRF por seguridad
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // Muestra el perfil del usuario autenticado con sus reseñas y listas
    public function profile()
    {
        $user = Auth::user();

        // with('contenido') carga la relación con el contenido de cada reseña para evitar consultas extra
        // latest() ordena por fecha de creación, de más reciente a más antigua
        $resenas = $user->resenas()->with('contenido')->latest()->get();

        // withCount('contenidos') añade un campo "contenidos_count" con el número de elementos en cada lista
        $listas = $user->listas()->withCount('contenidos')->latest()->take(4)->get();

        return view('auth.profile', compact('user', 'resenas', 'listas'));
    }

    // Muestra el formulario de edición de perfil
    public function editProfile()
    {
        return view('auth.edit-profile', ['user' => Auth::user()]);
    }

    // Procesa la actualización del perfil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // La regla 'unique:users,email,' . $user->id permite que el propio email del usuario
        // no cuente como duplicado (ignora su propio registro al validar unicidad)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Solo se actualiza la contraseña si el usuario rellenó ese campo
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Si se sube un archivo de avatar, se guarda en el disco 'public' dentro de /avatars
        // y se genera la URL pública correspondiente
        if ($request->hasFile('avatar')) {
            $rutaImagen = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = asset('storage/' . $rutaImagen);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente.');
    }
}