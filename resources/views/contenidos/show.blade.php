@extends('layouts.master')

@section('titulo', $contenido->titulo)

@section('contenido')
    <div class="contenedor-detalles">
        <div class="detalles-izq">
            <div class="details-poster" style="background-image: url('{{ $contenido->imagen_url }}');">
                @if(!$contenido->imagen_url)
                    <span class="details-poster-placeholder">Sin Imagen</span>
                @endif
            </div>

            <button class="boton boton-primario btn-block details-btn">
                {{ $contenido->tipo == 'serie' ? 'Ver Capítulos' : 'Ver Película' }}
            </button>
        </div>

        <div class="detalles-der">
            <h1 class="details-title">{{ $contenido->titulo }}</h1>

            <div class="meta-tags">
                <span class="tag">{{ $contenido->categoria->nombre }}</span>
                <span class="tag">{{ $contenido->año }}</span>
                <span class="tag">{{ $contenido->duracion ?? 'N/A' }}</span>
                <span class="tag tag-rating">★ {{ $contenido->puntuacion }}</span>
            </div>

            <p class="description details-description">
                {{ $contenido->descripcion }}
            </p>

            <div class="details-grid">
                <div>
                    <h4 class="details-subtitle">Director</h4>
                    <p>{{ $contenido->director ?? 'Desconocido' }}</p>
                </div>
                <div>
                    <h4 class="details-subtitle">Reparto</h4>
                    <p>{{ $contenido->reparto ?? 'No disponible' }}</p>
                </div>
            </div>

            <div class="reviews-section">
                <h3>Reseñas de la comunidad</h3>

                <div class="reviews-list">
                    @forelse($contenido->resenas as $resena)
                        <div class="review-card">
                            <div class="review-header" style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong>{{ $resena->user->name ?? 'Usuario Anónimo' }}</strong>
                                    <span class="review-rating">
                                        {{ str_repeat('★', $resena->puntuacion) }}
                                    </span>
                                </div>
                                @auth
                                    @if(Auth::id() === $resena->user_id)
                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('resenas.edit', $resena->id) }}" class="action-btn" style="text-decoration: none; padding: 4px 8px; font-size: 0.8rem;">
                                                ✏️ Editar
                                            </a>
                                            <form action="{{ route('resenas.destroy', $resena->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn" style="padding: 4px 8px; font-size: 0.8rem; color: #dc2626; border-color: #fca5a5;" onclick="return confirm('¿Seguro que deseas borrar esta reseña?');">
                                                    🗑️ Borrar
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                            <p style="margin-top: 10px;">{{ $resena->comentario }}</p>
                        </div>
                    @empty
                        <p class="text-gray">Aún no hay reseñas. ¡Sé el primero en opinar!</p>
                    @endforelse
                </div>

                <div class="tarjeta review-form-card">
                    <h4 class="review-form-title">Deja tu opinión</h4>

                    @auth
                        @if(session('success'))
                            <div class="alert alert-success mb-3 p-2 bg-green-100 text-green-800 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('resenas.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="contenido_id" value="{{ $contenido->id }}">

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Puntuación:</label>
                                <div id="star-rating" class="review-stars-interactive" data-old-value="{{ old('puntuacion') }}">
                                    <!-- Las estrellas se pintarán vivas con JavaScript -->
                                    <span class="star interactive-star" data-value="1">★</span>
                                    <span class="star interactive-star" data-value="2">★</span>
                                    <span class="star interactive-star" data-value="3">★</span>
                                    <span class="star interactive-star" data-value="4">★</span>
                                    <span class="star interactive-star" data-value="5">★</span>
                                </div>
                                <input type="hidden" name="puntuacion" id="puntuacion_input" value="{{ old('puntuacion') }}" required>
                                
                                @error('puntuacion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comentario" class="form-label font-weight-bold">Tu Reseña:</label>
                                <textarea name="comentario" id="comentario"
                                    class="form-textarea w-100 @error('comentario') is-invalid @enderror" rows="4"
                                    placeholder="¿Qué te pareció? Escribe aquí..." required>{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="review-submit-container mt-2">
                                <button type="submit" class="boton boton-primario">Publicar Reseña</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning p-3">
                            Debes <a href="{{ route('login') }}" class="font-weight-bold">iniciar sesión</a> para dejar una
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
            const stars = document.querySelectorAll('.interactive-star');
            const input = document.getElementById('puntuacion_input');
            const ratingContainer = document.getElementById('star-rating');
            const oldValue = ratingContainer.getAttribute('data-old-value');

            // Función para pintar estrellas hasta el valor X
            function highlightStars(value) {
                stars.forEach(star => {
                    star.style.color = star.getAttribute('data-value') <= value ? '#fbbf24' : '#ddd';
                });
            }

            // Si falló la validación y había value anterior, restaurarlo
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
                
                // Estilos rápidos CSS aplicados por JS 
                star.style.cursor = 'pointer';
                star.style.fontSize = '2rem';
                star.style.transition = 'color 0.2s ease-in-out';
                
                // Limpieza inicial
                if(!input.value && !oldValue) {
                    star.style.color = '#ddd';
                }
            });
        });
    </script>
    @endpush
@endsection