@extends('layouts.master')

@section('titulo', 'Editar Reseña')

@section('contenido')
<div class="contenedor pagina-formulario">
    <div class="tarjeta tarjeta-centrada">
        <h2 class="titulo-seccion">Editar tu Reseña</h2>
        
        <p class="text-gray mb-4">
            Estás modificando tu reseña para: <strong class="resena-titulo-obra">{{ $resena->contenido->titulo }}</strong>
        </p>

        @if ($errors->any())
            <div class="alerta-error mb-4">
                <ul class="lista-errores">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('resenas.update', $resena->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Se envía el contenido_id para que no falle la validación -->
            <input type="hidden" name="contenido_id" value="{{ $resena->contenido_id }}">

            <div class="form-group mb-4">
                <label class="font-bold mb-2 etiqueta-formulario">Puntuación:</label>
                <div id="star-rating" class="review-stars-interactive" data-old-value="{{ old('puntuacion', $resena->puntuacion) }}">
                    <span class="star estrella-interactiva" data-value="1">★</span>
                    <span class="star estrella-interactiva" data-value="2">★</span>
                    <span class="star estrella-interactiva" data-value="3">★</span>
                    <span class="star estrella-interactiva" data-value="4">★</span>
                    <span class="star estrella-interactiva" data-value="5">★</span>
                </div>
                <input type="hidden" name="puntuacion" id="puntuacion_input" value="{{ old('puntuacion', $resena->puntuacion) }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="comentario" class="font-bold mb-2 etiqueta-formulario">Tu Comentario:</label>
                <textarea name="comentario" id="comentario"
                    class="form-textarea" rows="6"
                    placeholder="Escribe aquí..." required>{{ old('comentario', $resena->comentario) }}</textarea>
            </div>

            <div class="flex gap-2 separador-superior">
                <button type="submit" class="boton boton-primario">Actualizar Reseña</button>
                <a href="{{ route('contenidos.show', $resena->contenido->slug) }}" class="boton boton-contorno">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.estrella-interactiva');
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
        });
    });
</script>
@endpush
@endsection
