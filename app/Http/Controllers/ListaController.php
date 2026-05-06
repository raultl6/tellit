<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use App\Models\Contenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaController extends Controller
{
    /**
     * Mostrar todas las listas del usuario autenticado.
     */
    public function index()
    {
        $listas = Auth::user()->listas()->withCount('contenidos')->latest()->get();
        return view('listas.index', compact('listas'));
    }

    /**
     * Mostrar el formulario para crear una nueva lista.
     */
    public function create()
    {
        return view('listas.create');
    }

    /**
     * Guardar una nueva lista en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Auth::user()->listas()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('listas.index')->with('success', 'Lista creada correctamente.');
    }

    /**
     * Mostrar una lista y sus contenidos.
     */
    public function show(Lista $lista)
    {
        // Solo el dueño puede ver su lista
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        $lista->load('contenidos');
        return view('listas.show', compact('lista'));
    }

    /**
     * Mostrar el formulario para editar una lista.
     */
    public function edit(Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        return view('listas.edit', compact('lista'));
    }

    /**
     * Actualizar una lista en la base de datos.
     */
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

    /**
     * Eliminar una lista de la base de datos.
     */
    public function destroy(Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        $lista->delete();

        return redirect()->route('listas.index')->with('success', 'Lista eliminada correctamente.');
    }

    /**
     * Alternar un contenido en una lista (añadir si no está, quitar si ya está).
     */
    public function toggleContenido(Request $request, Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        $request->validate([
            'contenido_id' => 'required|exists:contenidos,id',
        ]);

        // Alternar el contenido usando toggle() de Eloquent
        $lista->contenidos()->toggle($request->contenido_id);

        return back()->with('lista_success', 'Lista actualizada correctamente.');
    }
}
