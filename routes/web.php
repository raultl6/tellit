<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SumaController;

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
    return view('seccion.welcome');
});
Route::get('/inicio', function () {
    return view('seccion.inicio');
});
/*
Route::get('/suma', function () {
    return view('suma');
});
*/

Route::get('/suma', [SumaController::class, 'index']);

Route::post('/suma', function (Request $request) {
    $numero1 = $request->input('numero1');
    $numero2 = $request->input('numero2');
    $resultado = $numero1 + $numero2;

    return view('suma', ['resultado' => $resultado]);
});

Route::get('/inicio2', function () {
    return view('seccion.inicio2');
});