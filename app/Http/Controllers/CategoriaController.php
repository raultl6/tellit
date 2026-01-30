<?php

namespace App\Http\Controllers;

use App\Models\Categoria; // Importación del modelo
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        // Pedir todas las categorías a la base de datos
        $categorias = Categoria::all();

        // Enviarlas a la vista
        return view('categorias.index', compact('categorias'));
    }
}