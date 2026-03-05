<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    // Campos permitidos para carga masiva
    protected $fillable = [
        'puntuacion',
        'comentario',
        'contenido_id',
        'user_id',
    ];

    /**
     * Relación: Una Reseña pertenece a un Usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una Reseña pertenece a un Contenido.
     */
    public function contenido()
    {
        return $this->belongsTo(Contenido::class);
    }
}
