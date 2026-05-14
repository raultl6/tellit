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

    /**
     * Relación: Una Lista pertenece a un Usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una Lista tiene muchos Contenidos (Películas/Series).
     */
    public function contenidos()
    {
        return $this->belongsToMany(Contenido::class, 'contenido_lista')
                    ->withTimestamps();
    }
}
