<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use App\Models\Contenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaController extends Controller
{
    // Muestra todas las listas del usuario que ha iniciado sesión
    public function index()
    {
        // withCount('contenidos') añade un campo contenidos_count con el número de elementos en cada lista
        // latest() ordena de más reciente a más antigua
        $listas = Auth::user()->listas()->withCount('contenidos')->latest()->get();
        return view('listas.index', compact('listas'));
    }

    // Muestra el formulario para crear una nueva lista
    public function create()
    {
        return view('listas.create');
    }

    // Guarda una nueva lista en la base de datos, asociada al usuario autenticado
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Se crea la lista directamente asociada al usuario mediante la relación listas()
        // Laravel asigna automáticamente el user_id
        Auth::user()->listas()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('listas.index')->with('success', 'Lista creada correctamente.');
    }

    // Muestra una lista concreta y los contenidos que tiene dentro
    public function show(Lista $lista)
    {
        // Se verifica que el usuario sea el propietario de la lista.
        // abort(403) devuelve un error "Prohibido" si no coincide
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        // load() carga las relaciones después de obtener el modelo (carga diferida o lazy eager loading)
        $lista->load('contenidos');
        return view('listas.show', compact('lista'));
    }

    // Muestra el formulario de edición de una lista
    public function edit(Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        return view('listas.edit', compact('lista'));
    }

    // Actualiza los datos de una lista existente
    public function update(Request $request, Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $lista->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('listas.show', $lista)->with('success', 'Lista actualizada correctamente.');
    }

    // Elimina una lista de la base de datos
    public function destroy(Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        $lista->delete();

        return redirect()->route('listas.index')->with('success', 'Lista eliminada correctamente.');
    }

    // Añade o quita un contenido de una lista (funciona como interruptor)
    public function toggleContenido(Request $request, Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        $request->validate([
            'contenido_id' => 'required|exists:contenidos,id',
        ]);

        // toggle() es un método de Eloquent para relaciones muchos-a-muchos:
        // si el contenido ya está en la lista lo quita, si no está lo añade.
        // Esto evita tener que comprobar manualmente si ya existe
        $lista->contenidos()->toggle($request->contenido_id);

        return back()->with('lista_success', 'Lista actualizada correctamente.');
    }
}
