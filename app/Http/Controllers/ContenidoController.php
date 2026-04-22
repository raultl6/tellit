<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Categoria;
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

}

