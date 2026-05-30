<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        
        // 1. USUARIOS
        
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Admin',
            'email'      => 'admin@tellit.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user1Id = DB::table('users')->insertGetId([
            'name'       => 'Cinefilo23',
            'email'      => 'user@tellit.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user2Id = DB::table('users')->insertGetId([
            'name'       => 'SerieAddicta',
            'email'      => 'maria@tellit.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
        // 2. CATEGORÍAS
        
        $catAccion = DB::table('categorias')->insertGetId([
            'nombre'      => 'Acción',
            'slug'        => 'accion',
            'descripcion' => 'Tiros, persecuciones y adrenalina pura.',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $catDrama = DB::table('categorias')->insertGetId([
            'nombre'      => 'Drama',
            'slug'        => 'drama',
            'descripcion' => 'Historias intensas y profundamente emocionales.',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $catSciFi = DB::table('categorias')->insertGetId([
            'nombre'      => 'Ciencia Ficción',
            'slug'        => 'sci-fi',
            'descripcion' => 'Futuro, espacio y tecnología al límite.',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $catTerror = DB::table('categorias')->insertGetId([
            'nombre'      => 'Terror',
            'slug'        => 'terror',
            'descripcion' => 'Miedo, suspenso y criaturas de pesadilla.',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $catComedia = DB::table('categorias')->insertGetId([
            'nombre'      => 'Comedia',
            'slug'        => 'comedia',
            'descripcion' => 'Risas garantizadas para todos los públicos.',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        
        // 3. CONTENIDOS (Series)
        
        $dark = DB::table('contenidos')->insertGetId([
            'titulo'       => 'Dark',
            'slug'         => 'dark',
            'descripcion'  => 'Un thriller de ciencia ficción alemán que sigue a cuatro familias interconectadas de la pequeña ciudad de Winden, que descubren un misterioso agujero de gusano que conecta el pasado, el presente y el futuro.',
            'imagen_url'   => 'https://image.tmdb.org/t/p/w500/hRP7N2uI0pokxnkcMFONoOZnxbv.jpg',
            'año'          => 2017,
            'tipo'         => 'serie',
            'puntuacion'   => 4.9,
            'director'     => 'Baran bo Odar',
            'duracion'     => '3 Temporadas',
            'categoria_id' => $catSciFi,
            'created_at'   => now()->subDays(6),
            'updated_at'   => now()->subDays(6),
        ]);

        $strangerThings = DB::table('contenidos')->insertGetId([
            'titulo'       => 'Stranger Things',
            'slug'         => 'stranger-things',
            'descripcion'  => 'Cuando un niño desaparece, sus amigos, familia y un grupo de policías descubren un misterio que involucra experimentos secretos y fuerzas sobrenaturales aterradoras.',
            'imagen_url'   => 'https://image.tmdb.org/t/p/w500/49WJfeN0moxb9IPfGn8AIqMGskD.jpg',
            'año'          => 2016,
            'tipo'         => 'serie',
            'puntuacion'   => 4.6,
            'director'     => 'Matt Duffer, Ross Duffer',
            'duracion'     => '4 Temporadas',
            'categoria_id' => $catTerror,
            'created_at'   => now()->subDays(5),
            'updated_at'   => now()->subDays(5),
        ]);

        $invencible = DB::table('contenidos')->insertGetId([
            'titulo'       => 'Invencible',
            'slug'         => 'invencible',
            'descripcion'  => 'Mark Grayson es un adolescente normal, excepto que su padre es el superhéroe más poderoso del planeta. Al cumplir 17 años, Mark comienza a desarrollar sus propios poderes y descubre que el mundo de los superhéroes no es lo que parece.',
            'imagen_url'   => 'https://image.tmdb.org/t/p/w500/AdcfiT5FsjUooyP7CrKzEGmP9K1.jpg',
            'año'          => 2021,
            'tipo'         => 'serie',
            'puntuacion'   => 4.7,
            'director'     => 'Robert Kirkman',
            'duracion'     => '3 Temporadas',
            'categoria_id' => $catAccion,
            'created_at'   => now()->subDays(4),
            'updated_at'   => now()->subDays(4),
        ]);

        $breakingBad = DB::table('contenidos')->insertGetId([
            'titulo'       => 'Breaking Bad',
            'slug'         => 'breaking-bad',
            'descripcion'  => 'Un profesor de química con cáncer terminal se une a un ex-alumno para fabricar y vender metanfetamina con el fin de asegurar el futuro de su familia.',
            'imagen_url'   => 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg',
            'año'          => 2008,
            'tipo'         => 'serie',
            'puntuacion'   => 5.0,
            'director'     => 'Vince Gilligan',
            'duracion'     => '5 Temporadas',
            'categoria_id' => $catDrama,
            'created_at'   => now()->subDays(3),
            'updated_at'   => now()->subDays(3),
        ]);

        $flash = DB::table('contenidos')->insertGetId([
            'titulo'       => 'The Flash',
            'slug'         => 'the-flash',
            'descripcion'  => 'Barry Allen, un técnico forense de la policía, adquiere la capacidad de moverse a velocidades superhumanas después de ser alcanzado por un rayo durante un experimento fallido, convirtiéndose en el superhéroe The Flash.',
            'imagen_url'   => 'https://image.tmdb.org/t/p/w500/lJA2RCMfsWoskqlQhXPSLFQGXEJ.jpg',
            'año'          => 2014,
            'tipo'         => 'serie',
            'puntuacion'   => 4.1,
            'director'     => 'Greg Berlanti',
            'duracion'     => '9 Temporadas',
            'categoria_id' => $catAccion,
            'created_at'   => now()->subDays(2),
            'updated_at'   => now()->subDays(2),
        ]);

        $casaDePapel = DB::table('contenidos')->insertGetId([
            'titulo'       => 'La Casa de Papel',
            'slug'         => 'la-casa-de-papel',
            'descripcion'  => 'Un misterioso genio criminal conocido como "El Profesor" planea el atraco perfecto a la Fábrica Nacional de Moneda y Timbre de España, reuniendo a ocho ladrones con nombres de ciudades para llevar a cabo el golpe del siglo.',
            'imagen_url'   => 'https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg',
            'año'          => 2017,
            'tipo'         => 'serie',
            'puntuacion'   => 4.5,
            'director'     => 'Álex Pina',
            'duracion'     => '5 Temporadas',
            'categoria_id' => $catDrama,
            'created_at'   => now()->subDays(1),
            'updated_at'   => now()->subDays(1),
        ]);

        
        // 4. RESEÑAS
        
        DB::table('resenas')->insert([
            [
                'user_id'      => $user1Id,
                'contenido_id' => $breakingBad,
                'puntuacion'   => 5,
                'comentario'   => 'La mejor serie de la historia, sin discusión. Walter White es el personaje más bien escrito de la televisión.',
                'created_at'   => now()->subDays(5),
                'updated_at'   => now()->subDays(5),
            ],
            [
                'user_id'      => $user2Id,
                'contenido_id' => $breakingBad,
                'puntuacion'   => 5,
                'comentario'   => 'Empecé a verla un domingo y no pude parar. Perdí el sueño pero mereció la pena.',
                'created_at'   => now()->subDays(4),
                'updated_at'   => now()->subDays(4),
            ],
            [
                'user_id'      => $user1Id,
                'contenido_id' => $dark,
                'puntuacion'   => 5,
                'comentario'   => 'Dark es de otro nivel. Hay que verla con el árbol genealógico al lado, pero es una obra maestra.',
                'created_at'   => now()->subDays(3),
                'updated_at'   => now()->subDays(3),
            ],
            [
                'user_id'      => $user2Id,
                'contenido_id' => $strangerThings,
                'puntuacion'   => 5,
                'comentario'   => 'La nostalgia de los 80 mezclada con terror y aventura. Simplemente perfecta.',
                'created_at'   => now()->subDays(2),
                'updated_at'   => now()->subDays(2),
            ],
            [
                'user_id'      => $user1Id,
                'contenido_id' => $casaDePapel,
                'puntuacion'   => 4,
                'comentario'   => 'Las primeras temporadas son increíbles. La historia de El Profesor es brillante.',
                'created_at'   => now()->subDays(1),
                'updated_at'   => now()->subDays(1),
            ],
            [
                'user_id'      => $user2Id,
                'contenido_id' => $invencible,
                'puntuacion'   => 5,
                'comentario'   => 'Pensé que era un superhéroe normal y lo que encontré fue brutalmente oscuro y adictivo. ¡Brutal!',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        
        // 5. LISTAS
        
        $lista1 = DB::table('listas')->insertGetId([
            'nombre'      => 'Top Series de Ciencia Ficción',
            'descripcion' => 'Las mejores series de sci-fi y misterio que he visto.',
            'user_id'     => $user1Id,
            'created_at'  => now()->subDays(3),
            'updated_at'  => now()->subDays(3),
        ]);

        $lista2 = DB::table('listas')->insertGetId([
            'nombre'      => 'Para ver el fin de semana',
            'descripcion' => 'Series para maratonear este finde sin parar.',
            'user_id'     => $user2Id,
            'created_at'  => now()->subDays(1),
            'updated_at'  => now()->subDays(1),
        ]);

        // Contenidos en las listas
        DB::table('contenido_lista')->insert([
            ['contenido_id' => $dark,          'lista_id' => $lista1, 'created_at' => now(), 'updated_at' => now()],
            ['contenido_id' => $strangerThings,'lista_id' => $lista1, 'created_at' => now(), 'updated_at' => now()],
            ['contenido_id' => $invencible,    'lista_id' => $lista1, 'created_at' => now(), 'updated_at' => now()],
            ['contenido_id' => $breakingBad,   'lista_id' => $lista2, 'created_at' => now(), 'updated_at' => now()],
            ['contenido_id' => $casaDePapel,   'lista_id' => $lista2, 'created_at' => now(), 'updated_at' => now()],
            ['contenido_id' => $flash,         'lista_id' => $lista2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        
        // 6. MENSAJES DE CONTACTO (para demo del panel admin)
        
        DB::table('mensaje_contactos')->insert([
            [
                'nombre'     => 'Laura García',
                'email'      => 'laura@gmail.com',
                'asunto'     => 'Problema con mi cuenta',
                'mensaje'    => 'Hola, no puedo iniciar sesión en mi cuenta desde ayer. He probado a restablecer la contraseña pero no recibo el correo. ¿Me podéis ayudar?',
                'leido'      => false,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'nombre'     => 'Carlos Pérez',
                'email'      => 'carlos.perez@hotmail.com',
                'asunto'     => 'Sugerencia de contenido',
                'mensaje'    => 'Me encanta la plataforma, pero me gustaría que añadierais la saga de El Señor de los Anillos. Sería genial poder hacer reseñas de esas películas.',
                'leido'      => true,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'nombre'     => 'Ana Martínez',
                'email'      => 'ana.martinez@outlook.com',
                'asunto'     => 'Error en una reseña',
                'mensaje'    => 'Buenos días, he dejado una reseña errónea en Breaking Bad y me gustaría poder editarla o eliminarla. ¿Es posible hacerlo desde mi perfil?',
                'leido'      => false,
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5),
            ],
        ]);
    }
}