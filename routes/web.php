<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas web de la aplicación. Estas rutas son
| cargadas por el RouteServiceProvider dentro del grupo de middleware "web".
|
*/

// --- RUTAS PÚBLICAS (accesibles sin iniciar sesión) ---

// Página de inicio: muestra contenidos recientes, reseñas y el botón "Sorpréndeme"
Route::get('/', [ContenidoController::class, 'home'])->name('home');

// Devuelve un contenido aleatorio; acepta "exclude" para evitar repetir el anterior
Route::get('/aleatorio', [ContenidoController::class, 'random'])->name('contenidos.random');

// Página de exploración con filtros de búsqueda y categoría
Route::get('/explorar', [ContenidoController::class, 'index'])->name('contenidos.index');

// Detalle de una película/serie. {slug} es un identificador legible (ej: "inception", "breaking-bad")
Route::get('/ver/{slug}', [ContenidoController::class, 'show'])->name('contenidos.show');

// --- PÁGINAS ESTÁTICAS ---

// Muestra el formulario de contacto (vista directa, sin controlador)
Route::view('/contacto', 'contactos.index')->name('contacto');

// Procesa el envío del formulario de contacto: valida los datos y los guarda en la base de datos
Route::post('/contacto', function (\Illuminate\Http\Request $request) {
    // Se valida que todos los campos obligatorios estén presentes y con formato correcto
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'asunto' => 'required|string|max:255',
        'mensaje' => 'required|string',
    ]);

    // Se crea el registro directamente en la tabla mensajes_contactos
    \App\Models\MensajeContacto::create($request->all());

    // back() redirige a la misma página; with() envía un mensaje flash a la sesión
    return back()->with('success', '¡Gracias por contactarnos! Tu mensaje ha sido recibido y te responderemos a la brevedad.');
})->name('contacto.enviar');



// --- AUTENTICACIÓN (registro, login, logout, perfil) ---

// Formularios de registro
Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

// Formularios de login y cierre de sesión
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Perfil del usuario (requiere estar autenticado mediante el middleware 'auth')
Route::get('/perfil', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/perfil/editar', [AuthController::class, 'editProfile'])->name('profile.edit')->middleware('auth');
Route::put('/perfil/editar', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

// --- RESEÑAS ---
// Route::resource genera automáticamente las rutas CRUD estándar (store, edit, update, destroy)
// Con only() limitamos a las acciones que necesitamos; el middleware 'auth' protege todas ellas
Route::resource('resenas', App\Http\Controllers\ResenaController::class)->only([
    'store',
    'edit',
    'update',
    'destroy'
])->middleware('auth');

// --- LISTAS DE USUARIO ---
// Route::resource crea todas las rutas CRUD (index, create, store, show, edit, update, destroy)
Route::resource('listas', App\Http\Controllers\ListaController::class)->middleware('auth');

// Ruta extra para añadir o quitar un contenido de una lista (usa toggle: si está lo quita, si no lo añade)
Route::post('/listas/{lista}/toggle-contenido', [App\Http\Controllers\ListaController::class, 'toggleContenido'])->name('listas.toggle')->middleware('auth');

// --- PANEL DE ADMINISTRACIÓN ---
// prefix('admin') añade /admin/ delante de todas las rutas del grupo
// middleware(['auth', 'admin']) exige estar logueado y tener rol de administrador
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard principal: lista todos los títulos con paginación
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');

    // Gestión de usuarios: listar, banear/desbanear y eliminar
    Route::get('/usuarios', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::put('/usuarios/{id}/ban', [App\Http\Controllers\AdminController::class, 'toggleBan'])->name('admin.users.ban');
    Route::delete('/usuarios/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Gestión de reseñas: listar y eliminar
    Route::get('/resenas', [App\Http\Controllers\AdminController::class, 'reviews'])->name('admin.reviews');
    Route::delete('/resenas/{id}', [App\Http\Controllers\AdminController::class, 'destroyReview'])->name('admin.reviews.destroy');

    // Gestión de mensajes de contacto: listar y eliminar
    Route::get('/contactos', [App\Http\Controllers\AdminController::class, 'contactos'])->name('admin.contactos');
    Route::delete('/contactos/{id}', [App\Http\Controllers\AdminController::class, 'destroyContacto'])->name('admin.contactos.destroy');

    // Importación de contenidos desde la API de TMDB (The Movie Database)
    Route::get('/contenidos/nuevo', [App\Http\Controllers\AdminController::class, 'createContenido'])->name('admin.contenidos.create');
    Route::get('/tmdb/search', [App\Http\Controllers\AdminController::class, 'searchTmdb'])->name('admin.tmdb.search');
    Route::post('/contenidos/store-tmdb', [App\Http\Controllers\AdminController::class, 'storeTmdb'])->name('admin.contenidos.storeTmdb');
    Route::delete('/contenidos/{id}', [App\Http\Controllers\AdminController::class, 'destroyContenido'])->name('admin.contenidos.destroy');
});
