@extends('layouts.master')

@section('titulo', $contenido->titulo)

@section('contenido')
    <div class="details-container">
        <div class="details-left">
            <div class="details-poster"
                style="background-image: url('{{ $contenido->imagen_url }}'); background-size: cover; height: 400px; background-position: center; border-radius: 8px; background-color: #333;">
                @if(!$contenido->imagen_url) <span
                    style="display:flex; justify-content:center; align-items:center; height:100%; color:white;">Sin
                Imagen</span> @endif
            </div>

            <button class="btn btn-primary btn-block" style="margin-top: 15px;">
                {{ $contenido->tipo == 'serie' ? 'Ver Capítulos' : 'Ver Película' }}
            </button>
        </div>

        <div class="details-right">
            <h1 style="font-size: 2.5rem; margin-bottom: 5px;">{{ $contenido->titulo }}</h1>

            <div class="meta-tags">
                <span class="tag">{{ $contenido->categoria->nombre }}</span>
                <span class="tag">{{ $contenido->año }}</span>
                <span class="tag">{{ $contenido->duracion ?? 'N/A' }}</span>
                <span class="tag" style="background: #fbbf24; color: #000;">★ {{ $contenido->puntuacion }}</span>
            </div>

            <p class="description" style="margin-top: 20px; line-height: 1.6;">
                {{ $contenido->descripcion }}
            </p>

            <div style="margin-top: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <h4 style="color: #666; margin-bottom: 5px;">Director</h4>
                    <p>{{ $contenido->director ?? 'Desconocido' }}</p>
                </div>
                <div>
                    <h4 style="color: #666; margin-bottom: 5px;">Reparto</h4>
                    <p>{{ $contenido->reparto ?? 'No disponible' }}</p>
                </div>
            </div>

            <div style="margin-top: 50px; border-top: 1px solid #eee; padding-top: 30px;">
                <h3>Reseñas de la comunidad</h3>

                <div style="margin-bottom: 30px;">
                    @forelse($contenido->resenas as $resena)
                        <div class="review-card"
                            style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <strong>{{ $resena->user->name ?? 'Usuario Anónimo' }}</strong>
                                <span style="color: #fbbf24;">
                                    {{ str_repeat('★', $resena->puntuacion) }}
                                </span>
                            </div>
                            <p>{{ $resena->comentario }}</p>
                        </div>
                    @empty
                        <p class="text-gray">Aún no hay reseñas. ¡Sé el primero en opinar!</p>
                    @endforelse
                </div>

                <div class="card" style="background: #f8f8f8;">
                    <h4 style="margin-bottom: 10px;">Deja tu opinión</h4>
                    <div style="margin-bottom: 10px;">
                        <span style="font-size: 1.5rem; cursor: pointer; color: #fbbf24;">★</span>
                        <span style="font-size: 1.5rem; cursor: pointer; color: #fbbf24;">★</span>
                        <span style="font-size: 1.5rem; cursor: pointer; color: #fbbf24;">★</span>
                        <span style="font-size: 1.5rem; cursor: pointer; color: #ddd;">★</span>
                        <span style="font-size: 1.5rem; cursor: pointer; color: #ddd;">★</span>
                    </div>
                    <textarea class="form-textarea" placeholder="¿Qué te pareció la película? Escribe aquí..."></textarea>
                    <div style="text-align: right; margin-top: 10px;">
                        <button class="btn btn-primary">Publicar Reseña</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection