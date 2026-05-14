<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Campos permitidos para asignación masiva.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_banned',
    ];

    /**
     * Campos ocultos en la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Campos que se transforman automáticamente.
     */
    protected $casts = [
        'is_banned' => 'boolean',
    ];

    /**
     * Relación: Un Usuario tiene (escribe) muchas Reseñas.
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    /**
     * Relación: Un Usuario crea muchas Listas.
     */
    public function listas()
    {
        return $this->hasMany(Lista::class);
    }
}

