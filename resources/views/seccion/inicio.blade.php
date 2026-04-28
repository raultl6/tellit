@extends('layouts.master')

@section('titulo', 'Inicio')

@section('contenido')
    <!-- Hero / Portada Destacada -->
    <div class="portada-destacada">
        <div style="position: relative; z-index: 1;">
            <h2 class="portada-titulo">Bienvenido a TELLIT</h2>
            <p class="portada-subtitulo">Descubre, comparte y vive el cine.</p>
            
            <form action="{{ route('contenidos.index') }}" method="GET" class="portada-buscador">
                <input type="text" name="query" placeholder="Buscar película o serie..." class="portada-input">
                <button type="submit" class="boton boton-primario portada-btn">Buscar</button>
            </form>
        </div>
    </div>

    <div class="cuadricula cuadricula-3 seccion-añadidos">
        <!-- Añadidos Recientes -->
        <div class="home-grid-span-2">
            <h3 class="section-title">Añadidos Recientes</h3>
            @if($ultimosContenidos->count() > 0)
                <div class="cuadricula cuadricula-4">
                    @foreach($ultimosContenidos as $contenido)
                        <a href="{{ route('contenidos.show', $contenido->slug) }}" class="tarjeta tarjeta-añadido" title="{{ $contenido->titulo }}">
                            @if($contenido->imagen_url)
                                <img src="{{ $contenido->imagen_url }}" alt="{{ $contenido->titulo }}" class="tarjeta-añadido-img">
                                <div class="tarjeta-añadido-info">
                                    <span class="text-small font-bold texto-truncado-2">{{ $contenido->titulo }}</span>
                                </div>
                            @else
                                <div class="imagen-relleno imagen-tarjeta-inicio flex align-center justify-center text-center p-2 tarjeta-añadido-placeholder">
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
            <div class="random-icon">🎲</div>
            <h3>¿No sabes qué ver?</h3>
            <p class="text-gray text-small mb-4">Serie o Película, aquí lo encontrarás. Déjalo en nuestras manos.</p>
            <a href="{{ route('contenidos.random') }}" id="btn-sorprendeme" class="boton boton-primario btn-block">Sorpréndeme</a>
        </div>
    </div>

    <!-- Reseñas Recientes -->
    <h3 class="section-title">Reseñas Recientes</h3>
    @if($resenasRecientes->count() > 0)
        <div class="cuadricula cuadricula-3 seccion-reseñas">
            @foreach($resenasRecientes as $resena)
                <a href="{{ route('contenidos.show', $resena->contenido->slug) }}" class="tarjeta tarjeta-reseña">
                    <div class="flex mb-2 align-center">
                        <div class="foto-perfil avatar-mini">
                            {{ strtoupper(substr($resena->user->name, 0, 1)) }}
                        </div>
                        <div class="reseña-usuario-info">
                            <div class="font-bold text-small">{{ $resena->user->name }}</div>
                            <div class="text-yellow text-small reseña-estrellas">
                                {{ str_repeat('⭐', $resena->calificacion) }}
                            </div>
                        </div>
                    </div>
                    <div class="text-small font-bold mb-1 reseña-titulo-obra">{{ $resena->contenido->titulo }}</div>
                    <p class="text-gray text-small reseña-comentario">"{{ Str::limit($resena->comentario, 80) }}"</p>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray seccion-reseñas">Aún no hay reseñas en la plataforma. ¡Anímate a ser el primero!</p>
    @endif

    <!-- Botón Sorpréndeme -->
    <div id="modalSorprendeme" class="modal-sorprendeme">
        <div class="modal-sorprendeme-content">
            <span class="modal-sorprendeme-close" onclick="cerrarModalSorprendeme()">&times;</span>
            <div id="modalSorprendemeCargando" class="modal-sorprendeme-cargando">
                <p>Buscando algo increíble para ti...</p>
            </div>
            <div id="modalSorprendemeData" style="display: none;" class="modal-sorprendeme-body">
                <div class="modal-sorprendeme-img-container">
                    <img id="modalSorprendemeImg" src="" alt="Poster" class="modal-sorprendeme-img">
                </div>
                <div class="modal-sorprendeme-info">
                    <h3 id="modalSorprendemeTitle" class="modal-sorprendeme-title"></h3>
                    <p id="modalSorprendemeDesc" class="modal-sorprendeme-desc"></p>
                    <div class="modal-sorprendeme-buttons">
                        <button class="boton boton-secundario modal-btn-otra-vez" onclick="cargarSorpresaAleatoria()">Otra vez</button>
                        <a id="modalSorprendemeBtn" href="#" class="boton boton-primario">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('btn-sorprendeme').addEventListener('click', function(e) {
            e.preventDefault();
            abrirModalSorprendeme();
            cargarSorpresaAleatoria();
        });

        function abrirModalSorprendeme() {
            document.getElementById('modalSorprendeme').classList.add('show');
            document.getElementById('modalSorprendemeCargando').style.display = 'block';
            document.getElementById('modalSorprendemeData').style.display = 'none';
        }

        function cerrarModalSorprendeme() {
            document.getElementById('modalSorprendeme').classList.remove('show');
        }

        function cargarSorpresaAleatoria() {
            document.getElementById('modalSorprendemeCargando').style.display = 'block';
            document.getElementById('modalSorprendemeData').style.display = 'none';

            fetch('{{ route('contenidos.random') }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.error) {
                    alert('No se encontraron contenidos.');
                    cerrarModalSorprendeme();
                    return;
                }
                
                const img = document.getElementById('modalSorprendemeImg');
                if (data.imagen_url) {
                    img.src = data.imagen_url;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
                
                document.getElementById('modalSorprendemeTitle').innerText = data.titulo;
                document.getElementById('modalSorprendemeDesc').innerText = data.descripcion || 'Sin descripción disponible.';
                document.getElementById('modalSorprendemeBtn').href = data.url;

                document.getElementById('modalSorprendemeCargando').style.display = 'none';
                // Usar display flex en pantallas grandes, pero style.display overriding classes requires setting flex
                document.getElementById('modalSorprendemeData').style.display = window.innerWidth >= 600 ? 'flex' : 'block';
                // Añadimos una pequeña verificación por si cambia el tamaño de la ventana
                document.getElementById('modalSorprendemeData').classList.add('modal-sorprendeme-body');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al buscar un contenido aleatorio.');
                cerrarModalSorprendeme();
            });
        }

        // Cerrar modal al hacer click fuera
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('modalSorprendeme');
            if (e.target === modal) {
                cerrarModalSorprendeme();
            }
        });
    </script>
    @endpush
@endsection