@extends('layouts.master')

@section('titulo', 'Inicio')

@section('contenido')
    <!-- Hero / Portada Destacada -->
    <div class="portada-destacada" style="position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 4rem 2rem; border-radius: 12px; margin-bottom: 2rem;">
        <div style="position: relative; z-index: 1;">
            <h2 style="font-size: 3.5rem; margin-bottom: 0.5rem; font-weight: 800; letter-spacing: -1px; color: var(--primary-color);">Bienvenido a TELLIT</h2>
            <p style="font-size: 1.2rem; color: var(--text-color); opacity: 0.8; margin-bottom: 0;">Descubre, comparte y vive el cine.</p>
            
            <form action="{{ route('contenidos.index') }}" method="GET" style="margin-top: 2rem; max-width: 500px; margin-left: auto; margin-right: auto; display: flex; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 8px;">
                <input type="text" name="query" placeholder="Buscar película o serie..." style="flex: 1; padding: 1rem; border-radius: 8px 0 0 8px; border: 1px solid #e5e7eb; border-right: none; background: white; color: var(--text-dark); outline: none; font-size: 1rem;">
                <button type="submit" class="boton boton-primario" style="border-radius: 0 8px 8px 0; padding: 0 1.5rem; margin: 0; border: 1px solid var(--primary-color);">Buscar</button>
            </form>
        </div>
    </div>

    <div class="cuadricula cuadricula-3" style="margin-bottom: 3rem;">
        <!-- Añadidos Recientes -->
        <div class="home-grid-span-2">
            <h3 class="section-title">Añadidos Recientes</h3>
            @if($ultimosContenidos->count() > 0)
                <div class="cuadricula cuadricula-4">
                    @foreach($ultimosContenidos as $contenido)
                        <a href="{{ route('contenidos.show', $contenido->slug) }}" class="tarjeta" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;" title="{{ $contenido->titulo }}">
                            @if($contenido->imagen_url)
                                <img src="{{ $contenido->imagen_url }}" alt="{{ $contenido->titulo }}" style="width: 100%; height: 250px; object-fit: cover; display: block; border-radius: 8px 8px 0 0;">
                                <div style="padding: 10px; text-align: center;">
                                    <span class="text-small font-bold" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $contenido->titulo }}</span>
                                </div>
                            @else
                                <div class="imagen-relleno imagen-tarjeta-inicio flex align-center justify-center text-center p-2" style="height: 250px; border-radius: 8px 8px 0 0;">
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
        <div class="caja-aleatoria" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
            <div class="random-icon" style="font-size: 3rem; margin-bottom: 1rem;">🎲</div>
            <h3>¿No sabes qué ver?</h3>
            <p class="text-gray text-small mb-4">Serie o Película, aquí lo encontrarás. Déjalo en nuestras manos.</p>
            <a href="{{ route('contenidos.random') }}" id="btn-sorprendeme" class="boton boton-primario btn-block" style="display: inline-block;">Sorpréndeme</a>
        </div>
    </div>

    <!-- Reseñas Recientes -->
    <h3 class="section-title">Reseñas Recientes</h3>
    @if($resenasRecientes->count() > 0)
        <div class="cuadricula cuadricula-3" style="margin-bottom: 5rem;">
            @foreach($resenasRecientes as $resena)
                <a href="{{ route('contenidos.show', $resena->contenido->slug) }}" class="tarjeta" style="display: flex; flex-direction: column;">
                    <div class="flex mb-2" style="align-items: center;">
                        <div class="foto-perfil avatar-mini">
                            {{ strtoupper(substr($resena->user->name, 0, 1)) }}
                        </div>
                        <div style="margin-left: 10px;">
                            <div class="font-bold text-small">{{ $resena->user->name }}</div>
                            <div class="text-yellow text-small" style="letter-spacing: 2px;">
                                {{ str_repeat('⭐', $resena->calificacion) }}
                            </div>
                        </div>
                    </div>
                    <div class="text-small font-bold mb-1" style="color: var(--primary-color);">{{ $resena->contenido->titulo }}</div>
                    <p class="text-gray text-small" style="font-style: italic; flex: 1;">"{{ Str::limit($resena->comentario, 80) }}"</p>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray" style="margin-bottom: 5rem;">Aún no hay reseñas en la plataforma. ¡Anímate a ser el primero!</p>
    @endif
    @push('css')
    <style>
    /* Botón sorpréndeme */
    .modal-sorprendeme {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        align-items: center;
        justify-content: center;
    }
    .modal-sorprendeme.show {
        display: flex;
        animation: fadeIn 0.3s ease-in-out;
    }
    .modal-sorprendeme-content {
        background-color: var(--bg-card, #fff);
        padding: 0;
        border-radius: 12px;
        max-width: 700px;
        width: 90%;
        text-align: left;
        position: relative;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        overflow: hidden;
    }
    .modal-sorprendeme-close {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 1.5rem;
        color: white;
        cursor: pointer;
        z-index: 10;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-sorprendeme-close:hover {
        background: var(--primary-color, #e50914);
    }
    .modal-sorprendeme-body {
        display: flex;
        flex-direction: column;
    }
    @media (min-width: 600px) {
        .modal-sorprendeme-body {
            flex-direction: row;
        }
    }
    .modal-sorprendeme-img-container {
        flex: 0 0 40%;
        background-color: var(--bg-dark, #111);
        min-height: 300px;
    }
    .modal-sorprendeme-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .modal-sorprendeme-info {
        flex: 1;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .modal-sorprendeme-title {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: var(--primary-color, #e50914);
        line-height: 1.2;
    }
    .modal-sorprendeme-desc {
        font-size: 1rem;
        color: var(--text-gray, #ccc);
        margin-bottom: 2rem;
        line-height: 1.5;
    }
    .modal-sorprendeme-buttons {
        display: flex;
        gap: 1rem;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    </style>
    @endpush

    <!-- Botón Sorpréndeme -->
    <div id="modalSorprendeme" class="modal-sorprendeme">
        <div class="modal-sorprendeme-content">
            <span class="modal-sorprendeme-close" onclick="cerrarModalSorprendeme()">&times;</span>
            <div id="modalSorprendemeCargando" style="padding: 3rem; text-align: center;">
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
                        <button class="boton boton-secundario" onclick="cargarSorpresaAleatoria()" style="border: 1px solid var(--primary-color); background: transparent; color: var(--text-color); padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Otra vez</button>
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