<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    // Campos que se pueden rellenar al crear o actualizar una reseña
    protected $fillable = [
        'puntuacion',
        'comentario',
        'contenido_id',
        'user_id',
    ];

    // Relación "pertenece a": cada reseña fue escrita por un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación "pertenece a": cada reseña está asociada a un contenido (película o serie)
    public function contenido()
    {
        return $this->belongsTo(Contenido::class);
    }
}
