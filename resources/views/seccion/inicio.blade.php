@extends('layouts.master')

@section('titulo', 'Inicio')

@section('contenido')
    <!-- Portada Destacada -->
    <div class="portada-destacada">
        <div style="position: relative; z-index: 1;">
            <h2 class="portada-titulo">Bienvenido a TELLIT</h2>
            <p class="portada-subtitulo">Descubre, comparte y vive el cine.</p>
            
            {{-- Formulario de búsqueda: envía por GET a la página de exploración con el texto como parámetro --}}
            <form action="{{ route('contenidos.index') }}" method="GET" class="portada-buscador">
                <input type="text" name="query" placeholder="Buscar película o serie..." class="portada-input">
                <button type="submit" class="boton boton-primario portada-btn">Buscar</button>
            </form>
        </div>
    </div>

    <div class="cuadricula cuadricula-3 seccion-recientes">
        <!-- Añadidos Recientes -->
        <div class="home-grid-span-2">
            <h3 class="titulo-seccion">Añadidos Recientes</h3>
            {{-- Se comprueba si hay contenidos para mostrar; si no, se muestra un mensaje alternativo --}}
            @if($ultimosContenidos->count() > 0)
                <div class="cuadricula cuadricula-4">
                    @foreach($ultimosContenidos as $contenido)
                        <a href="{{ route('contenidos.show', $contenido->slug) }}" class="tarjeta tarjeta-contenido-reciente" title="{{ $contenido->titulo }}">
                            @if($contenido->imagen_url)
                                <img src="{{ $contenido->imagen_url }}" alt="{{ $contenido->titulo }}" class="tarjeta-contenido-reciente-img">
                                <div class="tarjeta-contenido-reciente-info">
                                    <span class="text-small font-bold texto-truncado-2">{{ $contenido->titulo }}</span>
                                </div>
                            @else
                                <div class="placeholder-inicio">
                                    <span class="text-small">{{ $contenido->titulo }}</span>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray">No hay contenidos añadidos recientemente.</p>
            @endif
        </div>

        <!-- Caja Aleatoria -->
        <div class="caja-aleatoria">
            <div class="icono-aleatorio">🎲</div>
            <h3>¿No sabes qué ver?</h3>
            <p class="text-gray text-small mb-4">¡Aquí está la respuesta!</p>
            <a href="{{ route('contenidos.random') }}" id="btn-sorprendeme" class="boton boton-primario btn-block">Sorpréndeme</a>
        </div>
    </div>

    <!-- Reseñas Recientes -->
    <h3 class="titulo-seccion">Reseñas Recientes</h3>
    @if($resenasRecientes->count() > 0)
        <div class="cuadricula cuadricula-3 seccion-resenas-inicio">
            @foreach($resenasRecientes as $resena)
                <a href="{{ route('contenidos.show', $resena->contenido->slug) }}" class="tarjeta tarjeta-resena">
                    <div class="flex mb-2 align-center">
                        <div class="foto-perfil avatar-mini">
                            {{-- Si el usuario no tiene avatar personalizado, se genera uno automático con sus iniciales --}}
                            <img src="{{ $resena->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($resena->user->name) . '&background=6366f1&color=fff' }}" alt="{{ $resena->user->name }}" class="img-avatar-redonda">
                        </div>
                        <div class="resena-usuario-info">
                            <div class="font-bold text-small">{{ $resena->user->name }}</div>
                            <div class="text-yellow text-small resena-estrellas">
                                {{-- str_repeat repite el emoji de estrella tantas veces como puntuación tenga --}}
                                {{ str_repeat('⭐', $resena->puntuacion) }}
                            </div>
                        </div>
                    </div>
                    <div class="text-small font-bold mb-1 resena-titulo-obra">{{ $resena->contenido->titulo }}</div>
                    {{-- Str::limit recorta el texto a 80 caracteres y añade "..." al final --}}
                    <p class="text-gray text-small resena-comentario">"{{ Str::limit($resena->comentario, 80) }}"</p>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray seccion-resenas-inicio">Aún no hay reseñas en la plataforma. ¡Anímate a ser el primero!</p>
    @endif

    <!-- Modal Sorpréndeme: ventana emergente que muestra el resultado aleatorio -->
    <div id="modalSorprendeme" class="modal-sorprendeme">
        <div class="modal-sorprendeme-content">
            <span class="modal-sorprendeme-close" onclick="cerrarModalSorprendeme()">&times;</span>
            <div id="modalSorprendemeData" class="modal-sorprendeme-body">
                <div class="modal-sorprendeme-img-container">
                    <img id="modalSorprendemeImg" src="" alt="Poster" class="modal-sorprendeme-img">
                </div>
                <div class="modal-sorprendeme-info">
                    <h3 id="modalSorprendemeTitle" class="modal-sorprendeme-title"></h3>
                    <p id="modalSorprendemeDesc" class="modal-sorprendeme-desc"></p>
                    <div class="modal-sorprendeme-buttons">
                        <button class="boton boton-contorno modal-btn-otra-vez" onclick="cargarSorpresaAleatoria()">Otra vez</button>
                        <a id="modalSorprendemeBtn" href="#" class="boton boton-primario">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Al hacer clic en "Sorpréndeme", se evita la navegación normal (preventDefault)
        // y se abre el modal con una petición AJAX al servidor
        document.getElementById('btn-sorprendeme').addEventListener('click', function(e) {
            e.preventDefault();
            abrirModalSorprendeme();
            cargarSorpresaAleatoria();
        });

        // Muestra el modal añadiendo la clase CSS 'show' y oculta los datos anteriores
        function abrirModalSorprendeme() {
            document.getElementById('modalSorprendeme').classList.add('show');
            document.getElementById('modalSorprendemeData').classList.remove('cargado');
        }

        // Oculta el modal quitando la clase CSS 'show'
        function cerrarModalSorprendeme() {
            document.getElementById('modalSorprendeme').classList.remove('show');
        }

        // Variable para recordar el último contenido mostrado y no repetirlo
        let lastSorpresaId = null;

        // Función asíncrona que pide un contenido aleatorio al servidor sin recargar la página
        async function cargarSorpresaAleatoria() {
            // Se ocultan los datos anteriores mientras se carga el nuevo resultado
            document.getElementById('modalSorprendemeData').classList.remove('cargado');

            try {
                // Se construye la URL añadiendo el parámetro 'exclude' si ya se mostró un resultado antes,
                // para que el servidor no devuelva el mismo contenido dos veces seguidas
                let url = '{{ route('contenidos.random') }}';
                if (lastSorpresaId) {
                    url += '?exclude=' + lastSorpresaId;
                }

                // Promise.all ejecuta la petición fetch y un temporizador de 300ms a la vez.
                // Esto garantiza que el estado de "cargando" se muestre al menos 300ms,
                // evitando un parpadeo demasiado rápido si la respuesta es instantánea
                const [response] = await Promise.all([
                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',             // Indica al servidor que queremos respuesta en JSON
                            'X-Requested-With': 'XMLHttpRequest'      // Identifica la petición como AJAX
                        }
                    }),
                    new Promise(resolve => setTimeout(resolve, 300))
                ]);

                // Se convierte la respuesta del servidor a un objeto JavaScript
                const data = await response.json();

                if(data.error) {
                    alert('No se encontraron contenidos.');
                    cerrarModalSorprendeme();
                    return;
                }

                // Se guarda el ID del contenido actual para excluirlo en la próxima petición
                lastSorpresaId = data.id;
                
                // Se actualiza la imagen del modal con el póster recibido
                const img = document.getElementById('modalSorprendemeImg');
                if (data.imagen_url) {
                    img.src = data.imagen_url;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
                
                // Se rellenan los campos del modal con los datos del contenido aleatorio
                document.getElementById('modalSorprendemeTitle').innerText = data.titulo;
                document.getElementById('modalSorprendemeDesc').innerText = data.descripcion || 'Sin descripción disponible.';
                document.getElementById('modalSorprendemeBtn').href = data.url;

                // La clase 'cargado' hace visible el contenido con una transición CSS
                document.getElementById('modalSorprendemeData').classList.add('cargado');
            } catch (error) {
                console.error('Error:', error);
                alert('Hubo un error al buscar un contenido aleatorio.');
                cerrarModalSorprendeme();
            }
        }

        // Se cierra el modal si el usuario hace clic fuera del contenido (en el fondo oscuro)
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('modalSorprendeme');
            if (e.target === modal) {
                cerrarModalSorprendeme();
            }
        });
    </script>
    @endpush
@endsection