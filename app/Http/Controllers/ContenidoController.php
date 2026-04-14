<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    public function index()
    {
        // 1. Traem todo el contenido (Pelis y Series)
        $contenidos = Contenido::all();

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

