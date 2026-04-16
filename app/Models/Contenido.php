<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    use HasFactory;

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

    // Relación: Una peli pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación: Una peli tiene muchas reseñas
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }
}