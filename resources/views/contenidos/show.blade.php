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
                    <div class="review-stars">
                        <span class="star-active">★</span>
                        <span class="star-active">★</span>
                        <span class="star-active">★</span>
                        <span class="star-inactive">★</span>
                        <span class="star-inactive">★</span>
                    </div>
                    <textarea class="form-textarea" placeholder="¿Qué te pareció la película? Escribe aquí..."></textarea>
                    <div class="review-submit-container">
                        <button class="btn btn-primary">Publicar Reseña</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection