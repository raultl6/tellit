<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller{

    // Muestra el formulario de creación de reseña
    public function create(){
        $contenidos = \App\Models\Contenido::all();
        return view('resenas.create', compact('contenidos'));
    }

    // Guarda una nueva reseña en la base de datos
     public function store(Request $request){
        // Se validan los datos del formulario.
        // 'exists:contenidos,id' comprueba que el contenido_id corresponda a un registro real en la tabla contenidos
        $validatedData = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
            'contenido_id' => 'required|exists:contenidos,id',
        ]);

        // Se asigna automáticamente el ID del usuario logueado como autor de la reseña
        $validatedData['user_id'] = Auth::id();

        // Se crea el registro usando asignación masiva con los datos ya validados
        $resena = Resena::create($validatedData);

        // Se redirige a la página del contenido reseñado usando el slug de su relación
        return redirect()->route('contenidos.show', $resena->contenido->slug)->with('success', 'Reseña publicada correctamente.');
    }

    // Muestra el formulario de edición de una reseña
    public function edit($id){
        // findOrFail() busca la reseña por su ID; si no existe devuelve un error 404
        $resena = Resena::findOrFail($id);

        // Se verifica que el usuario logueado sea el autor de la reseña
        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para editar esta reseña.');
        }

        return view('resenas.edit', compact('resena'));
    }

    // Actualiza una reseña existente en la base de datos
    public function update(Request $request, $id){
        $resena = Resena::findOrFail($id);

        // Verificación de propiedad: solo el autor puede modificar su reseña
        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para actualizar esta reseña.');
        }

        $validatedData = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
            'contenido_id' => 'required|exists:contenidos,id',
        ]);

        // update() solo modifica los campos proporcionados en el array validado
        $resena->update($validatedData);

        return redirect()->route('contenidos.show', $resena->contenido->slug)
                         ->with('success', 'Reseña actualizada correctamente.');
    }

    // Elimina una reseña de la base de datos
    public function destroy($id){
        $resena = Resena::findOrFail($id);

        // Solo el autor de la reseña puede eliminarla
        if (Auth::id() != $resena->user_id) {
            abort(403, 'No tienes permiso para borrar esta reseña.');
        }

        // Se guarda el slug antes de borrar, porque después de delete() ya no se puede acceder a la relación
        $slug = $resena->contenido->slug;
        $resena->delete();

        return redirect()->route('contenidos.show', $slug)
                         ->with('success', 'Reseña eliminada correctamente.');
    }
}
