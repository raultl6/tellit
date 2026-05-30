<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id',
    ];

    // Relación "pertenece a": cada lista fue creada por un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación "muchos a muchos": una lista puede contener múltiples contenidos,
    // y un mismo contenido puede estar en varias listas distintas.
    // La tabla intermedia 'contenido_lista' almacena estas relaciones
    public function contenidos()
    {
        return $this->belongsToMany(Contenido::class, 'contenido_lista')
                    ->withTimestamps();
    }
}
