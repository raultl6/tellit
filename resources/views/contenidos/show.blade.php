@extends('layouts.master')

@section('titulo', $contenido->titulo)

@section('contenido')
    <div class="details-container">
        <div class="details-left">
            <div class="details-poster" style="background-image: url('{{ $contenido->imagen_url }}');">
                @if(!$contenido->imagen_url)
                    <span class="details-poster-placeholder">Sin Imagen</span>
                @endif
            </div>

            <button class="btn btn-primary btn-block details-btn">
                {{ $contenido->tipo == 'serie' ? 'Ver Capítulos' : 'Ver Película' }}
            </button>
        </div>

        <div class="details-right">
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
                            <div class="review-header">
                                <strong>{{ $resena->user->name ?? 'Usuario Anónimo' }}</strong>
                                <span class="review-rating">
                                    {{ str_repeat('★', $resena->puntuacion) }}
                                </span>
                            </div>
                            <p>{{ $resena->comentario }}</p>
                        </div>
                    @empty
                        <p class="text-gray">Aún no hay reseñas. ¡Sé el primero en opinar!</p>
                    @endforelse
                </div>

                <div class="card review-form-card">
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
                                <label for="puntuacion" class="form-label font-weight-bold">Puntuación:</label>
                                <select name="puntuacion" id="puntuacion"
                                    class="form-select w-auto d-inline-block @error('puntuacion') is-invalid @enderror"
                                    required>
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="5" {{ old('puntuacion') == '5' ? 'selected' : '' }}>5 Estrellas - Excelente
                                    </option>
                                    <option value="4" {{ old('puntuacion') == '4' ? 'selected' : '' }}>4 Estrellas - Muy Buena
                                    </option>
                                    <option value="3" {{ old('puntuacion') == '3' ? 'selected' : '' }}>3 Estrellas - Buena
                                    </option>
                                    <option value="2" {{ old('puntuacion') == '2' ? 'selected' : '' }}>2 Estrellas - Regular
                                    </option>
                                    <option value="1" {{ old('puntuacion') == '1' ? 'selected' : '' }}>1 Estrella - Mala</option>
                                </select>
                                @error('puntuacion')
                                    <br><small class="text-danger">{{ $message }}</small>
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
                                <button type="submit" class="btn btn-primary">Publicar Reseña</button>
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
@endsection