@extends('layouts.master')

@section('titulo', 'Editar Reseña')

@section('contenido')
<div class="contenedor" style="padding: 50px 0;">
    <div class="tarjeta" style="max-width: 650px; margin: 0 auto;">
        <h2 class="section-title">Editar tu Reseña</h2>
        
        <p class="text-gray" style="margin-bottom: 25px;">
            Estás modificando tu reseña para: <strong style="color: var(--primary);">{{ $resena->contenido->titulo }}</strong>
        </p>

        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('resenas.update', $resena->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Aseguramos que se envía el contenido_id para que no falle la validación -->
            <input type="hidden" name="contenido_id" value="{{ $resena->contenido_id }}">

            <div class="form-group mb-4">
                <label class="font-bold mb-2" style="display: block;">Puntuación:</label>
                <div id="star-rating" class="review-stars-interactive" data-old-value="{{ old('puntuacion', $resena->puntuacion) }}">
                    <span class="star interactive-star" data-value="1">★</span>
                    <span class="star interactive-star" data-value="2">★</span>
                    <span class="star interactive-star" data-value="3">★</span>
                    <span class="star interactive-star" data-value="4">★</span>
                    <span class="star interactive-star" data-value="5">★</span>
                </div>
                <input type="hidden" name="puntuacion" id="puntuacion_input" value="{{ old('puntuacion', $resena->puntuacion) }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="comentario" class="font-bold mb-2" style="display: block;">Tu Comentario:</label>
                <textarea name="comentario" id="comentario"
                    class="form-textarea" rows="6"
                    placeholder="Escribe aquí..." required>{{ old('comentario', $resena->comentario) }}</textarea>
            </div>

            <div class="flex gap-2" style="padding-top: 20px; border-top: 1px solid #eee; margin-top: 10px;">
                <button type="submit" class="boton boton-primario">Actualizar Reseña</button>
                <a href="{{ route('contenidos.show', $resena->contenido->slug) }}" class="boton boton-contorno">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.interactive-star');
        const input = document.getElementById('puntuacion_input');
        const ratingContainer = document.getElementById('star-rating');
        const oldValue = ratingContainer.getAttribute('data-old-value');

        function highlightStars(value) {
            stars.forEach(star => {
                star.style.color = star.getAttribute('data-value') <= value ? '#fbbf24' : '#ddd';
            });
        }

        if (oldValue) highlightStars(oldValue);

        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                highlightStars(this.getAttribute('data-value'));
            });

            star.addEventListener('mouseout', function() {
                highlightStars(input.value || oldValue || 0);
            });

            star.addEventListener('click', function() {
                input.value = this.getAttribute('data-value');
                highlightStars(input.value);
            });
            
            star.style.cursor = 'pointer';
            star.style.fontSize = '2.5rem'; 
            star.style.transition = 'color 0.2s ease-in-out';
            
            if(!input.value && !oldValue) {
                star.style.color = '#ddd';
            }
        });
    });
</script>
@endpush
@endsection
