<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Contenido;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Resena;
use App\Models\Reporte;

class AdminController extends Controller
{
    public function index()
    {
        $contenidos = Contenido::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.index', compact('contenidos'));
    }

    public function users()
    {
        $usuarios = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('usuarios'));
    }

    public function reviews()
    {
        $resenas = Resena::with(['user', 'contenido'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews', compact('resenas'));
    }

    public function reports()
    {
        $reportes = Reporte::with(['user', 'reportable'])->where('estado', 'pendiente')->orderBy('created_at', 'asc')->paginate(10);
        return view('admin.reports', compact('reportes'));
    }

    // --- INTEGRACIÓN TMDB ---

    public function createContenido()
    {
        return view('admin.contenidos.create');
    }

    public function searchTmdb(Request $request)
    {
        $query = $request->get('q');
        if (!$query) {
            return response()->json([]);
        }

        $apiKey = config('services.tmdb.key');
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');

        $response = Http::get("{$baseUrl}/search/multi", [
            'api_key' => $apiKey,
            'query' => $query,
            'language' => 'es-ES',
            'include_adult' => false
        ]);

        if ($response->successful()) {
            // Filtrar y devolver solo películas y series (ignorar personas)
            $results = collect($response->json('results'))
                ->filter(function ($item) {
                    return in_array($item['media_type'], ['movie', 'tv']);
                })
                ->values()
                ->take(10); // Mostrar máximo 10 sugerencias

            return response()->json($results);
        }

        return response()->json([]);
    }

    public function storeTmdb(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required|integer',
            'tmdb_type' => 'required|in:movie,tv'
        ]);

        $id = $request->tmdb_id;
        $type = $request->tmdb_type;
        $apiKey = config('services.tmdb.key');
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');

        // Hacer petición extra append_to_response para traer equipo técnico y actores al mismo tiempo
        $response = Http::get("{$baseUrl}/{$type}/{$id}", [
            'api_key' => $apiKey,
            'language' => 'es-ES',
            'append_to_response' => 'credits'
        ]);

        if (!$response->successful()) {
            return redirect()->route('admin.index')->with('error', 'No se pudo conectar con TMDB.');
        }

        $data = $response->json();
        $titulo = $type === 'movie' ? $data['title'] : $data['name'];
        $slug = Str::slug($titulo);

        // Evitar duplicados
        if (Contenido::where('slug', $slug)->exists()) {
            return redirect()->route('admin.index')->with('error', 'El título ya existe en la base de datos.');
        }

        // Obtener / Crear Categoría (Tomamos el primer género)
        $categoriaId = null;
        if (!empty($data['genres'])) {
            $primerGenero = $data['genres'][0]['name'];
            $categoria = Categoria::firstOrCreate(
                ['slug' => Str::slug($primerGenero)],
                ['nombre' => $primerGenero]
            );
            $categoriaId = $categoria->id;
        }

        // Director y Reparto
        $director = null;
        $reparto = [];
        if (isset($data['credits'])) {
            $crew = $data['credits']['crew'] ?? [];
            foreach ($crew as $member) {
                if ($member['job'] === 'Director') {
                    $director = $member['name'];
                    break;
                }
            }
            if ($type === 'tv' && !$director && !empty($data['created_by'])) {
                // Las series suelen usar 'created_by'
                $director = collect($data['created_by'])->pluck('name')->implode(', ');
            }

            $cast = array_slice($data['credits']['cast'] ?? [], 0, 5);
            foreach ($cast as $actor) {
                $reparto[] = $actor['name'];
            }
        }

        // Adaptar campos dependiendo de si es peli o serie
        $duracion = $type === 'movie' ? ($data['runtime'] . 'm') : (count($data['seasons'] ?? []) . ' Temporadas');
        $posterPath = !empty($data['poster_path']) ? "https://image.tmdb.org/t/p/w500" . $data['poster_path'] : null;
        
        $año = null;
        if ($type === 'movie' && !empty($data['release_date'])) {
            $año = substr($data['release_date'], 0, 4);
        } elseif ($type === 'tv' && !empty($data['first_air_date'])) {
            $año = substr($data['first_air_date'], 0, 4);
        }

        // Calcular puntuación base 5 (TMDB es base 10)
        $puntuacionBase5 = isset($data['vote_average']) ? round($data['vote_average'] / 2, 1) : 0;

        // Guardar
        Contenido::create([
            'titulo' => $titulo,
            'slug' => $slug,
            'descripcion' => $data['overview'] ?: 'Sin descripción disponible.',
            'imagen_url' => $posterPath,
            'año' => $año,
            'tipo' => $type === 'movie' ? 'pelicula' : 'serie',
            'puntuacion' => $puntuacionBase5,
            'director' => $director,
            'duracion' => $duracion,
            'reparto' => implode(', ', $reparto),
            'categoria_id' => $categoriaId,
        ]);

        return redirect()->route('admin.index')->with('success', "¡'{$titulo}' importado correctamente desde TMDB!");
    }

    public function destroyContenido($id)
    {
        $contenido = Contenido::findOrFail($id);
        $contenido->delete();

        return redirect()->route('admin.index')->with('success', 'Título eliminado correctamente.');
    }

    public function toggleBan($id)
    {
        $usuario = User::findOrFail($id);
        
        // Evitar que el admin se banee a sí mismo
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'No puedes banearte a ti mismo.');
        }

        $usuario->is_banned = !$usuario->is_banned;
        $usuario->save();

        $estado = $usuario->is_banned ? 'baneado' : 'desbaneado';
        return redirect()->route('admin.users')->with('success', "El usuario {$usuario->name} ha sido {$estado}.");
    }

    public function destroyUser($id)
    {
        $usuario = User::findOrFail($id);
        
        // Evitar que el admin se borre a sí mismo
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $usuario->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
    }

    public function destroyReview($id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return redirect()->route('admin.reviews')->with('success', 'Reseña eliminada correctamente.');
    }

    public function resolveReport(Request $request, $id)
    {
        $reporte = Reporte::findOrFail($id);
        $accion = $request->input('accion'); // 'ignorar' o 'borrar'

        if ($accion === 'borrar') {
            // Borrar el recurso asociado
            if ($reporte->reportable) {
                $reporte->reportable->delete();
            }
            $mensaje = 'Recurso borrado y reporte resuelto.';
        } else {
            $mensaje = 'Reporte marcado como resuelto (ignorado).';
        }

        $reporte->estado = 'revisado'; // Update 'estado' enum: 'pendiente', 'revisado'
        $reporte->save();

        return redirect()->route('admin.reports')->with('success', $mensaje);
    }
}
