<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ContenidoController::class, 'home'])->name('home');
Route::get('/aleatorio', [ContenidoController::class, 'random'])->name('contenidos.random');

Route::get('/explorar', [ContenidoController::class, 'index'])->name('contenidos.index');

// La parte {slug} es el comodín, como el nombre facil (ej: inception, breaking-bad)
Route::get('/ver/{slug}', [ContenidoController::class, 'show'])->name('contenidos.show');



// Rutas de Registro
Route::get('/registro', [AuthController::class, 'showRegister'])->name('register'); // Ver formulario
Route::post('/registro', [AuthController::class, 'register'])->name('register.post'); // Enviar datos

// Rutas de Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/perfil', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/perfil/editar', [AuthController::class, 'editProfile'])->name('profile.edit')->middleware('auth');
Route::put('/perfil/editar', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

// Rutas de Reseñas
Route::resource('resenas', App\Http\Controllers\ResenaController::class)->only([
    'create',
    'store',
    'edit',
    'update',
    'destroy'
])->middleware('auth');
Route::resource('resenas', App\Http\Controllers\ResenaController::class)->except([
    'create',
    'store',
    'edit',
    'update',
    'destroy'
]);

// Rutas de Listas
Route::resource('listas', App\Http\Controllers\ListaController::class)->middleware('auth');
Route::post('/listas/{lista}/toggle-contenido', [App\Http\Controllers\ListaController::class, 'toggleContenido'])->name('listas.toggle')->middleware('auth');

// Rutas de Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/usuarios', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::put('/usuarios/{id}/ban', [App\Http\Controllers\AdminController::class, 'toggleBan'])->name('admin.users.ban');
    Route::delete('/usuarios/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/resenas', [App\Http\Controllers\AdminController::class, 'reviews'])->name('admin.reviews');
    Route::delete('/resenas/{id}', [App\Http\Controllers\AdminController::class, 'destroyReview'])->name('admin.reviews.destroy');
    Route::get('/reportes', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
    Route::put('/reportes/{id}/resolver', [App\Http\Controllers\AdminController::class, 'resolveReport'])->name('admin.reports.resolve');

    // TMDB y Contenidos
    Route::get('/contenidos/nuevo', [App\Http\Controllers\AdminController::class, 'createContenido'])->name('admin.contenidos.create');
    Route::get('/tmdb/search', [App\Http\Controllers\AdminController::class, 'searchTmdb'])->name('admin.tmdb.search');
    Route::post('/contenidos/store-tmdb', [App\Http\Controllers\AdminController::class, 'storeTmdb'])->name('admin.contenidos.storeTmdb');
    Route::delete('/contenidos/{id}', [App\Http\Controllers\AdminController::class, 'destroyContenido'])->name('admin.contenidos.destroy');
});


