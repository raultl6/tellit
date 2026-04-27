<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Categoria;
use App\Models\Resena;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Contenido::query();

        if ($request->filled('query')) {
            $query->where('titulo', 'LIKE', '%' . $request->input('query') . '%');
        }

        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->input('categoria'));
        }

        // 1. Trae el contenido filtrado
        $contenidos = $query->get();

        // 2. Trae las categorías para el filtro del sidebar
        $categorias = Categoria::all();

        // 3. Junta los datos y los manda a la vista
        return view('contenidos.index', compact('contenidos', 'categorias'));
    }

    public function show($slug)
    {
        $contenido = Contenido::where('slug', $slug)->firstOrFail();
        return view('contenidos.show', compact('contenido'));
    }

    public function home()
    {
        $ultimosContenidos = Contenido::orderBy('created_at', 'desc')->take(4)->get();
        $resenasRecientes = Resena::with(['user', 'contenido'])->orderBy('created_at', 'desc')->take(3)->get();
        
        $destacado = Contenido::orderBy('created_at', 'desc')->first();

        return view('seccion.inicio', compact('ultimosContenidos', 'resenasRecientes', 'destacado'));
    }

    public function random()
    {
        $contenido = Contenido::inRandomOrder()->first();
        if ($contenido) {
            return redirect()->route('contenidos.show', $contenido->slug);
        }
        return redirect()->route('home');
    }
}
