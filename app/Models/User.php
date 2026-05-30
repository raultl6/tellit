<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// User extiende de Authenticatable (no de Model), lo que le permite gestionar sesiones y autenticación
class User extends Authenticatable
{
    // HasApiTokens: permite gestionar tokens de API (Sanctum)
    // HasFactory: permite crear usuarios de prueba con factories
    // Notifiable: permite enviar notificaciones al usuario
    use HasApiTokens, HasFactory, Notifiable;

    // Campos que se pueden rellenar mediante asignación masiva
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_banned',
    ];

    // Campos que se ocultan al convertir el modelo a JSON o array (por seguridad)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversiones automáticas de tipo: is_banned se trata como booleano (true/false) en vez de 0/1
    protected $casts = [
        'is_banned' => 'boolean',
    ];

    // Relación "tiene muchas": un usuario puede escribir múltiples reseñas
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    // Relación "tiene muchas": un usuario puede crear múltiples listas personalizadas
    public function listas()
    {
        return $this->hasMany(Lista::class);
    }
}

