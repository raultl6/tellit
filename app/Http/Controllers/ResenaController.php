<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller{

    // CREACION DE RESEÑAS
    public function create(){
        $contenidos = \App\Models\Contenido::all();
        return view('resenas.create', compact('contenidos'));
    }

    // GUARDADO DE RESEÑAS
     public function store(Request $request){
        // 1. Se validan los datos entrantes del request
        $validatedData = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
            'contenido_id' => 'required|exists:contenidos,id',
        ]);

        // 2. Se asigna automáticamente el user_id usando el usuario autenticado
        $validatedData['user_id'] = Auth::id();

        // 3. Se guarda la reseña en la base de datos
        $resena = Resena::create($validatedData);

        // 4. Se redirige con un mensaje de éxito
        return redirect()->route('contenidos.show', $resena->contenido->slug)->with('success', 'Reseña publicada correctamente.');
    }

    // EDICION DE RESEÑAS
    public function edit($id){
        $resena = Resena::findOrFail($id);

        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para editar esta reseña.');
        }

        return view('resenas.edit', compact('resena'));
    }

    // ACTUALIZACION DE RESEÑAS
    public function update(Request $request, $id){
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
                         ->with('success', 'Reseña actualizada correctamente.');
    }

    // ELIMINACION DE RESEÑAS
    public function destroy($id){
        $resena = Resena::findOrFail($id);

        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para borrar esta reseña.');
        }

        $slug = $resena->contenido->slug;
        $resena->delete();

        return redirect()->route('contenidos.show', $slug)
                         ->with('success', 'Reseña eliminada correctamente.');
    }
}
