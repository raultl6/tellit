<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. CREAR USUARIOS
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin Tellit',
            'email' => 'admin@tellit.com',
            'password' => Hash::make('12345678'), // La contraseña es 12345678
            'role' => 'admin',
            'avatar' => 'https://i.pravatar.cc/150?u=admin',
        ]);

        // Usuario Normal
        DB::table('users')->insert([
            'name' => 'Cinefilo23',
            'email' => 'user@tellit.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'avatar' => 'https://i.pravatar.cc/150?u=user',
        ]);

        // 2. CREAR CATEGORÍAS
        // Guardamos el ID para usarlo luego
        $catAccion = DB::table('categorias')->insertGetId([
            'nombre' => 'Acción',
            'slug' => 'accion',
            'descripcion' => 'Tiros, persecuciones y adrenalina.',
        ]);

        $catDrama = DB::table('categorias')->insertGetId([
            'nombre' => 'Drama',
            'slug' => 'drama',
            'descripcion' => 'Historias intensas y emocionales.',
        ]);

        $catSciFi = DB::table('categorias')->insertGetId([
            'nombre' => 'Ciencia Ficción',
            'slug' => 'sci-fi',
            'descripcion' => 'Futuro, espacio y tecnología.',
        ]);

        // 3. CREAR CONTENIDOS (Pelis y Series)
        $peli1 = DB::table('contenidos')->insertGetId([
            'titulo' => 'Inception',
            'slug' => 'inception',
            'descripcion' => 'Un ladrón roba secretos a través de los sueños.',
            'imagen_url' => 'https://via.placeholder.com/300x450?text=Inception',
            'año' => 2010,
            'tipo' => 'pelicula',
            'puntuacion' => 4.8,
            'director' => 'Christopher Nolan',
            'duracion' => '2h 28m',
            'categoria_id' => $catSciFi, // La vinculamos a Sci-Fi
        ]);

        $serie1 = DB::table('contenidos')->insertGetId([
            'titulo' => 'Breaking Bad',
            'slug' => 'breaking-bad',
            'descripcion' => 'Un profesor de química cocina metanfetamina.',
            'imagen_url' => 'https://via.placeholder.com/300x450?text=Breaking+Bad',
            'año' => 2008,
            'tipo' => 'serie',
            'puntuacion' => 5.0,
            'director' => 'Vince Gilligan',
            'duracion' => '5 Temporadas',
            'categoria_id' => $catDrama, // La vinculamos a Drama
        ]);

        // 4. CREAR RESEÑAS
        DB::table('resenas')->insert([
            'user_id' => 2, // El usuario Cinefilo23
            'contenido_id' => $peli1, // Reseña de Inception
            'puntuacion' => 5,
            'comentario' => 'Me explotó la cabeza, increíble.',
            'likes' => 10,
        ]);
    }
}