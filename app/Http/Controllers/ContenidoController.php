<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Categoria;
use App\Models\Resena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        
        $listasUsuario = [];
        if (Auth::check()) {
            $listasUsuario = Auth::user()->listas()->get();
        }

        return view('contenidos.show', compact('contenido', 'listasUsuario'));
    }

    public function home()
    {
        $ultimosContenidos = Contenido::orderBy('created_at', 'desc')->take(4)->get();
        $resenasRecientes = Resena::with(['user', 'contenido'])->orderBy('created_at', 'desc')->take(3)->get();
        
        $destacado = Contenido::orderBy('created_at', 'desc')->first();

        return view('seccion.inicio', compact('ultimosContenidos', 'resenasRecientes', 'destacado'));
    }

    public function random(Request $request)
    {
        $contenido = Contenido::inRandomOrder()->first();
        if ($contenido) {
            if ($request->wantsJson()) {
                return response()->json([
                    'titulo' => $contenido->titulo,
                    'descripcion' => Str::limit($contenido->descripcion, 200),
                    'imagen_url' => $contenido->imagen_url,
                    'url' => route('contenidos.show', $contenido->slug)
                ]);
            }
            return redirect()->route('contenidos.show', $contenido->slug);
        }
        
        if ($request->wantsJson()) {
            return response()->json(['error' => 'No hay contenidos'], 404);
        }
        return redirect()->route('home');
    }
}
