<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Categoria; // Importamos Categoría también
use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    public function index()
    {
        // 1. Traem todo el contenido (Pelis y Series)
        $contenidos = Contenido::all();

        // 2. Trae las categorías para el filtro del sidebar
        $categorias = Categoria::all();

        // 3. Envia ambos paquetes de datos a la vista
        return view('contenidos.index', compact('contenidos', 'categorias'));
    }
}