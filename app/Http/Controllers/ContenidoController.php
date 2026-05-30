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
    // Muestra la página de exploración con filtros opcionales de búsqueda y categoría
    public function index(Request $request)
    {
        // Se inicia una consulta base sobre el modelo Contenido
        $query = Contenido::query();

        // Si el usuario escribió algo en el buscador, se filtra por título.
        // LIKE '%texto%' busca coincidencias parciales (que el título contenga ese texto)
        if ($request->filled('query')) {
            $query->where('titulo', 'LIKE', '%' . $request->input('query') . '%');
        }

        // Si el usuario seleccionó un género, se filtra por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->input('categoria'));
        }

        // with('resenas') precarga las reseñas asociadas para calcular la puntuación media sin consultas adicionales
        $contenidos = $query->with('resenas')->get();

        // Se obtienen todas las categorías para mostrarlas en el selector de filtros
        $categorias = Categoria::all();

        // compact() crea un array asociativo con las variables, equivale a ['contenidos' => $contenidos, 'categorias' => $categorias]
        return view('contenidos.index', compact('contenidos', 'categorias'));
    }

    // Muestra el detalle de un contenido concreto, identificado por su slug
    public function show($slug)
    {
        // with('resenas.user') precarga las reseñas y el usuario que escribió cada una (relación anidada)
        // firstOrFail() devuelve un error 404 si no encuentra el contenido
        $contenido = Contenido::with('resenas.user')->where('slug', $slug)->firstOrFail();
        
        // Si hay un usuario logueado, se obtienen sus listas para el selector "Añadir a lista"
        $listasUsuario = [];
        if (Auth::check()) {
            $listasUsuario = Auth::user()->listas()->get();
        }

        return view('contenidos.show', compact('contenido', 'listasUsuario'));
    }

    // Muestra la página de inicio con los contenidos más recientes y las últimas reseñas
    public function home()
    {
        // take(4) limita el resultado a los 4 más recientes
        $ultimosContenidos = Contenido::orderBy('created_at', 'desc')->take(4)->get();

        // Se cargan las reseñas con sus relaciones (usuario y contenido) para mostrar nombre y título
        $resenasRecientes = Resena::with(['user', 'contenido'])->orderBy('created_at', 'desc')->take(3)->get();
        
        $destacado = Contenido::orderBy('created_at', 'desc')->first();

        return view('seccion.inicio', compact('ultimosContenidos', 'resenasRecientes', 'destacado'));
    }

    // Devuelve un contenido aleatorio. Puede responder en JSON (para el modal) o con una redirección
    public function random(Request $request)
    {
        // inRandomOrder() ordena los resultados de forma aleatoria en la base de datos
        $query = Contenido::inRandomOrder();

        // Si se recibe un parámetro "exclude", se excluye ese contenido para no repetir el mismo resultado seguido
        if ($request->filled('exclude')) {
            $query->where('id', '!=', $request->input('exclude'));
        }

        $contenido = $query->first();

        // Si no se encontró ningún resultado (porque solo hay un contenido en la base de datos),
        // se repite la consulta sin excluir nada como respaldo
        if (!$contenido && $request->filled('exclude')) {
            $contenido = Contenido::inRandomOrder()->first();
        }

        if ($contenido) {
            // wantsJson() detecta si la petición viene con cabecera Accept: application/json (petición AJAX)
            if ($request->wantsJson()) {
                return response()->json([
                    'id' => $contenido->id,
                    'titulo' => $contenido->titulo,
                    'descripcion' => Str::limit($contenido->descripcion, 200),
                    'imagen_url' => $contenido->imagen_url,
                    'url' => route('contenidos.show', $contenido->slug)
                ]);
            }
            // Si es una petición normal (navegador), se redirige a la página del contenido
            return redirect()->route('contenidos.show', $contenido->slug);
        }
        
        // Si no hay ningún contenido en la base de datos, se devuelve un error
        if ($request->wantsJson()) {
            return response()->json(['error' => 'No hay contenidos'], 404);
        }
        return redirect()->route('home');
    }
}
