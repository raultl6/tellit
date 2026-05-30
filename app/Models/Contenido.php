<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    use HasFactory;

    // $fillable define qué campos se pueden rellenar mediante asignación masiva (create, update).
    // Los campos que no estén aquí se ignoran por seguridad, evitando que alguien modifique campos no permitidos
    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'imagen_url',
        'año',
        'tipo',
        'puntuacion',
        'director',
        'duracion',
        'reparto',
        'categoria_id',
    ];

    // Relación "pertenece a": cada contenido tiene una sola categoría (género)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación "tiene muchas": un contenido puede tener múltiples reseñas de distintos usuarios
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    // Relación "muchos a muchos": un contenido puede aparecer en muchas listas de diferentes usuarios.
    // Se usa la tabla intermedia 'contenido_lista' para almacenar estas asociaciones.
    // withTimestamps() guarda la fecha de cuándo se añadió a cada lista
    public function listas()
    {
        return $this->belongsToMany(Lista::class, 'contenido_lista')
                    ->withTimestamps();
    }
}