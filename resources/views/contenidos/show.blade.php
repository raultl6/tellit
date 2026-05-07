@extends('layouts.master')

@section('titulo', $contenido->titulo)

@section('contenido')
    <div class="contenedor-detalles">
        <div class="detalles-izq">
            <div class="poster-detalles" style="background-image: url('{{ $contenido->imagen_url }}');">
                @if(!$contenido->imagen_url)
                    <span class="poster-detalles-placeholder">Sin Imagen</span>
                @endif
            </div>

            @auth
                @if($listasUsuario->count() > 0)
                    <div class="tarjeta p-3 caja-add-lista">
                        <h4>Añadir a lista:</h4>
                        <form action="" method="POST" id="form-add-lista" onsubmit="if(!document.getElementById('lista_selector').value) { alert('Selecciona una lista primero'); return false; }">
                            @csrf
                            <input type="hidden" name="contenido_id" value="{{ $contenido->id }}">
                            <div class="selector-flex">
                                <select id="lista_selector" class="form-input selector-lista" onchange="document.getElementById('form-add-lista').action = '{{ url('listas') }}/' + this.value + '/toggle-contenido'">
                                    <option value="">Selecciona...</option>
                                    @foreach($listasUsuario as $lista)
                                        <option value="{{ $lista->id }}" {{ $lista->contenidos->contains($contenido->id) ? 'disabled' : '' }}>
                                            {{ $lista->nombre }} {{ $lista->contenidos->contains($contenido->id) ? '✓' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="boton boton-primario boton-sm">Añadir</button>
                            </div>
                        </form>
                        @if(session('lista_success'))
                            <div class="mensaje-lista-exito">
                                {{ session('lista_success') }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center enlace-crear-lista">
                        <a href="{{ route('listas.create') }}">Crear mi primera lista</a>
                    </div>
                @endif
            @endauth
        </div>

        <div class="detalles-der">
            <h1 class="titulo-detalles">{{ $contenido->titulo }}</h1>

            <div class="etiquetas-meta">
                <span class="etiqueta">{{ $contenido->categoria->nombre }}</span>
                <span class="etiqueta">{{ $contenido->año }}</span>
                <span class="etiqueta">{{ $contenido->duracion ?? 'N/A' }}</span>
                @if($contenido->resenas->count() > 0)
                    <span class="etiqueta etiqueta-puntuacion">★ {{ number_format($contenido->resenas->avg('puntuacion'), 1) }}</span>
                @endif
            </div>

            <p class="descripcion-detalles">
                {{ $contenido->descripcion }}
            </p>

            <div class="cuadricula-detalles">
                <div>
                    <h4 class="subtitulo-detalles">Director</h4>
                    <p>{{ $contenido->director ?? 'Desconocido' }}</p>
                </div>
                <div>
                    <h4 class="subtitulo-detalles">Reparto</h4>
                    <p>{{ $contenido->reparto ?? 'No disponible' }}</p>
                </div>
            </div>

            <div class="seccion-resenas">
                <h3>Reseñas de la comunidad</h3>

                <div class="lista-resenas">
                    @forelse($contenido->resenas as $resena)
                        <div class="tarjeta-resena-detalle">
                            <div class="cabecera-resena">
                                <div>
                                    <strong>{{ $resena->user->name ?? 'Usuario Anónimo' }}</strong>
                                    <span class="puntuacion-resena">
                                        {{ str_repeat('★', $resena->puntuacion) }}
                                    </span>
                                </div>
                                @auth
                                    @if(Auth::id() === $resena->user_id)
                                        <div class="acciones-resena">
                                            <a href="{{ route('resenas.edit', $resena->id) }}" class="boton-accion">
                                                ✏️ Editar
                                            </a>
                                            <form action="{{ route('resenas.destroy', $resena->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="boton-accion boton-accion-borrar" onclick="return confirm('¿Seguro que deseas borrar esta reseña?');">
                                                    🗑️ Borrar
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                            <p class="texto-resena-detalle">{{ $resena->comentario }}</p>
                        </div>
                    @empty
                        <p class="text-gray">Aún no hay reseñas. ¡Sé el primero en opinar!</p>
                    @endforelse
                </div>

                <div class="tarjeta tarjeta-formulario-resena">
                    <h4 class="titulo-formulario-resena">Deja tu opinión</h4>

                    @auth
                        @if(session('success'))
                            <div class="alerta-exito mb-2">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('resenas.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="contenido_id" value="{{ $contenido->id }}">

                            <div class="mb-2">
                                <label class="font-bold etiqueta-formulario">Puntuación:</label>
                                <div id="star-rating" class="review-stars-interactive" data-old-value="{{ old('puntuacion') }}">
                                    <!-- Las estrellas se activan con JavaScript -->
                                    <span class="star estrella-interactiva" data-value="1">★</span>
                                    <span class="star estrella-interactiva" data-value="2">★</span>
                                    <span class="star estrella-interactiva" data-value="3">★</span>
                                    <span class="star estrella-interactiva" data-value="4">★</span>
                                    <span class="star estrella-interactiva" data-value="5">★</span>
                                </div>
                                <input type="hidden" name="puntuacion" id="puntuacion_input" value="{{ old('puntuacion') }}" required>
                                
                                @error('puntuacion')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label for="comentario" class="font-bold etiqueta-formulario">Tu Reseña:</label>
                                <textarea name="comentario" id="comentario"
                                    class="form-textarea" rows="4"
                                    placeholder="¿Qué te pareció? Escribe aquí..." required>{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="contenedor-envio-resena mt-2">
                                <button type="submit" class="boton boton-primario">Publicar Reseña</button>
                            </div>
                        </form>
                    @else
                        <div class="p-3">
                            Debes <a href="{{ route('login') }}" class="font-bold">iniciar sesión</a> para dejar una
                            reseña.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.estrella-interactiva');
            const input = document.getElementById('puntuacion_input');
            const ratingContainer = document.getElementById('star-rating');
            const oldValue = ratingContainer.getAttribute('data-old-value');

            // Función para pintar estrellas hasta el valor X
            function highlightStars(value) {
                stars.forEach(star => {
                    star.style.color = star.getAttribute('data-value') <= value ? '#fbbf24' : '#ddd';
                });
            }

            // Si falla la validación y había valor anterior, restaurarlo
            if (oldValue) highlightStars(oldValue);

            stars.forEach(star => {
                // Al pasar por encima, iluminamos
                star.addEventListener('mouseover', function() {
                    highlightStars(this.getAttribute('data-value'));
                });

                // Al salir, volvemos a la nota seleccionada o cero
                star.addEventListener('mouseout', function() {
                    highlightStars(input.value || oldValue || 0);
                });

                // Al hacer clic, fijamos el valor definitivo
                star.addEventListener('click', function() {
                    input.value = this.getAttribute('data-value');
                    highlightStars(input.value);
                });
            });
        });
    </script>
    @endpush
@endsection