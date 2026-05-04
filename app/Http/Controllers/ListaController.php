<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use App\Models\Contenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaController extends Controller
{
    /**
     * Display a listing of the user's lists.
     */
    public function index()
    {
        $listas = Auth::user()->listas()->withCount('contenidos')->latest()->get();
        return view('listas.index', compact('listas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('listas.create');
    }

    /**
     * Store a newly created list in storage.
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
     * Display the specified list and its contents.
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
     * Show the form for editing the specified list.
     */
    public function edit(Lista $lista)
    {
        if (Auth::id() !== $lista->user_id) {
            abort(403);
        }

        return view('listas.edit', compact('lista'));
    }

    /**
     * Update the specified list in storage.
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
     * Remove the specified list from storage.
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
     * Toggle a content item in the specified list (add if missing, remove if exists).
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
