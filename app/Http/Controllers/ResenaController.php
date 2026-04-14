<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contenidos = \App\Models\Contenido::all();
        return view('resenas.create', compact('contenidos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos entrantes del request
        $validatedData = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
            'contenido_id' => 'required|exists:contenidos,id',
        ]);

        // 2. Asignamos automáticamente el user_id usando el usuario autenticado
        $validatedData['user_id'] = Auth::id();

        // 3. Guardamos la reseña en la base de datos
        $resena = Resena::create($validatedData);

        // 4. Redirigimos con un mensaje de éxito
        return redirect()->route('contenidos.show', $resena->contenido->slug)->with('success', '¡Tu reseña ha sido publicada exitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resena = Resena::findOrFail($id);

        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para editar esta reseña.');
        }

        return view('resenas.edit', compact('resena'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resena = Resena::findOrFail($id);

        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para actualizar esta reseña.');
        }

        $validatedData = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
            'contenido_id' => 'required|exists:contenidos,id',
        ]);

        $resena->update($validatedData);

        return redirect()->route('contenidos.show', $resena->contenido->slug)
                         ->with('success', '¡Tu reseña ha sido actualizada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resena = Resena::findOrFail($id);

        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para borrar esta reseña.');
        }

        $slug = $resena->contenido->slug;
        $resena->delete();

        return redirect()->route('contenidos.show', $slug)
                         ->with('success', '¡Tu reseña ha sido eliminada exitosamente!');
    }
}
