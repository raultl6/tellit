<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Contenido;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Resena;
use App\Models\MensajeContacto;

class AdminController extends Controller
{
    // Página principal del panel de administración: lista todos los títulos con paginación
    public function index()
    {
        // paginate(10) divide los resultados en páginas de 10 elementos, generando enlaces de navegación
        $contenidos = Contenido::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.index', compact('contenidos'));
    }

    // Lista todos los usuarios registrados con paginación
    public function users()
    {
        $usuarios = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('usuarios'));
    }

    // Lista todas las reseñas junto con el usuario y el contenido asociado
    public function reviews()
    {
        // with(['user', 'contenido']) precarga las relaciones para evitar consultas extra por cada reseña
        $resenas = Resena::with(['user', 'contenido'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews', compact('resenas'));
    }

    // Lista todos los mensajes de contacto recibidos
    public function contactos()
    {
        $contactos = MensajeContacto::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contactos', compact('contactos'));
    }

    // --- INTEGRACIÓN CON LA API DE TMDB (The Movie Database) ---

    // Muestra el formulario de búsqueda para importar contenidos desde TMDB
    public function createContenido()
    {
        return view('admin.contenidos.create');
    }

    // Busca películas y series en la API de TMDB y devuelve los resultados en formato JSON
    public function searchTmdb(Request $request)
    {
        $query = $request->get('q');
        if (!$query) {
            return response()->json([]);
        }

        // Se obtienen las credenciales de la API desde la configuración (config/services.php)
        $apiKey = config('services.tmdb.key');
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');

        // Http::get() hace una petición GET a la API externa de TMDB
        // 'search/multi' busca tanto películas como series a la vez
        $response = Http::get("{$baseUrl}/search/multi", [
            'api_key' => $apiKey,
            'query' => $query,
            'language' => 'es-ES',
            'include_adult' => false
        ]);

        if ($response->successful()) {
            // Se filtran los resultados para quedarse solo con películas y series (ignorar personas)
            // collect() convierte el array en una colección de Laravel para usar métodos funcionales
            $results = collect($response->json('results'))
                ->filter(function ($item) {
                    return in_array($item['media_type'], ['movie', 'tv']);
                })
                ->values()    // Reinicia los índices del array tras filtrar
                ->take(10);   // Limita a 10 resultados como máximo

            return response()->json($results);
        }

        return response()->json([]);
    }

    // Importa un título específico desde TMDB y lo guarda en la base de datos local
    public function storeTmdb(Request $request)
    {
        // Se valida que se reciban el ID de TMDB y el tipo (película o serie)
        $request->validate([
            'tmdb_id' => 'required|integer',
            'tmdb_type' => 'required|in:movie,tv'
        ]);

        $id = $request->tmdb_id;
        $type = $request->tmdb_type;
        $apiKey = config('services.tmdb.key');
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');

        // Se pide el detalle completo del título a la API.
        // 'append_to_response=credits' incluye el reparto y equipo técnico en la misma petición,
        // lo que ahorra hacer una segunda llamada a la API
        $response = Http::get("{$baseUrl}/{$type}/{$id}", [
            'api_key' => $apiKey,
            'language' => 'es-ES',
            'append_to_response' => 'credits'
        ]);

        if (!$response->successful()) {
            return redirect()->route('admin.index')->with('error', 'No se pudo conectar con TMDB.');
        }

        $data = $response->json();

        // El nombre del campo varía según el tipo: las películas usan 'title', las series usan 'name'
        $titulo = $type === 'movie' ? $data['title'] : $data['name'];

        // Str::slug() convierte el título en un formato apto para URLs (sin espacios, sin acentos, en minúsculas)
        $slug = Str::slug($titulo);

        // Se comprueba si ya existe un contenido con ese slug para evitar duplicados
        if (Contenido::where('slug', $slug)->exists()) {
            return redirect()->route('admin.index')->with('error', 'El título ya existe en la base de datos.');
        }

        // Se busca o crea la categoría a partir del primer género que devuelve la API.
        // firstOrCreate() busca por slug; si no existe, lo crea con el nombre proporcionado
        $categoriaId = null;
        if (!empty($data['genres'])) {
            $primerGenero = $data['genres'][0]['name'];
            $categoria = Categoria::firstOrCreate(
                ['slug' => Str::slug($primerGenero)],
                ['nombre' => $primerGenero]
            );
            $categoriaId = $categoria->id;
        }

        // Se busca el director recorriendo el equipo técnico (crew) hasta encontrar el cargo "Director"
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
            // Las series no siempre tienen director; en su lugar se usa el campo 'created_by' (creador de la serie)
            if ($type === 'tv' && !$director && !empty($data['created_by'])) {
                $director = collect($data['created_by'])->pluck('name')->implode(', ');
            }

            // Se obtienen los primeros 5 actores del reparto
            $cast = array_slice($data['credits']['cast'] ?? [], 0, 5);
            foreach ($cast as $actor) {
                $reparto[] = $actor['name'];
            }
        }

        // Se adaptan los campos según el tipo de contenido.
        // Para películas se guarda la duración en minutos; para series, el número de temporadas
        $duracion = $type === 'movie' ? ($data['runtime'] . 'm') : (count($data['seasons'] ?? []) . ' Temporadas');

        // Se construye la URL completa del póster usando la ruta base de imágenes de TMDB
        $posterPath = !empty($data['poster_path']) ? "https://image.tmdb.org/t/p/w500" . $data['poster_path'] : null;
        
        // Se extrae el año de estreno (los primeros 4 caracteres de la fecha)
        $año = null;
        if ($type === 'movie' && !empty($data['release_date'])) {
            $año = substr($data['release_date'], 0, 4);
        } elseif ($type === 'tv' && !empty($data['first_air_date'])) {
            $año = substr($data['first_air_date'], 0, 4);
        }

        // La puntuación de TMDB va de 0 a 10; se divide entre 2 para adaptarla a nuestra escala de 0 a 5
        $puntuacionBase5 = isset($data['vote_average']) ? round($data['vote_average'] / 2, 1) : 0;

        // Se guarda el contenido en la base de datos con todos los datos recopilados
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

    // Elimina un contenido de la base de datos
    public function destroyContenido($id)
    {
        // findOrFail() busca por ID y devuelve un error 404 si no existe
        $contenido = Contenido::findOrFail($id);
        $contenido->delete();

        return redirect()->route('admin.index')->with('success', 'Título eliminado correctamente.');
    }

    // Banea o desbanea a un usuario (alterna el estado)
    public function toggleBan($id)
    {
        $usuario = User::findOrFail($id);
        
        // Se impide que el administrador se banee a sí mismo por accidente
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'No puedes banearte a ti mismo.');
        }

        // Se invierte el estado actual: si estaba baneado pasa a activo, y viceversa
        $usuario->is_banned = !$usuario->is_banned;
        $usuario->save();

        $estado = $usuario->is_banned ? 'baneado' : 'desbaneado';
        return redirect()->route('admin.users')->with('success', "El usuario {$usuario->name} ha sido {$estado}.");
    }

    // Elimina un usuario de la base de datos
    public function destroyUser($id)
    {
        $usuario = User::findOrFail($id);
        
        // Se impide que el administrador elimine su propia cuenta
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $usuario->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
    }

    // Elimina una reseña de la base de datos (moderación)
    public function destroyReview($id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return redirect()->route('admin.reviews')->with('success', 'Reseña eliminada correctamente.');
    }

    // Elimina un mensaje de contacto
    public function destroyContacto($id)
    {
        $contacto = MensajeContacto::findOrFail($id);
        $contacto->delete();

        return redirect()->route('admin.contactos')->with('success', 'Mensaje eliminado correctamente.');
    }
}
