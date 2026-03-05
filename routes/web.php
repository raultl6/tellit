<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\AuthController;

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
Route::get('/', function () {
    return view('seccion.inicio');
})->name('home');


Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');


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

// Rutas de Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/usuarios', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/resenas', [App\Http\Controllers\AdminController::class, 'reviews'])->name('admin.reviews');
    Route::get('/reportes', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
});