@extends('layouts.master')

@section('contenido')
    <div class="contenedor my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="tarjeta shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Escribir una Reseña</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('resenas.store') }}" method="POST">
                            @csrf

                            {{-- Selector de Contenido --}}
                            <div class="mb-3">
                                <label for="contenido_id" class="form-label">¿Qué contenido quieres reseñar?</label>
                                <select name="contenido_id" id="contenido_id"
                                    class="form-select @error('contenido_id') is-invalid @enderror">
                                    <option value="" disabled selected>Selecciona una opción...</option>
                                    @foreach($contenidos as $contenido)
                                        <option value="{{ $contenido->id }}" {{ old('contenido_id') == $contenido->id ? 'selected' : '' }}>
                                            {{ $contenido->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('contenido_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Puntuación --}}
                            <div class="mb-3">
                                <label for="puntuacion" class="form-label">Puntuación (1 al 5)</label>
                                <select name="puntuacion" id="puntuacion"
                                    class="form-select @error('puntuacion') is-invalid @enderror">
                                    <option value="" disabled selected>Elige una puntuación...</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('puntuacion') == $i ? 'selected' : '' }}>{{ $i }}
                                            Estrella(s)</option>
                                    @endfor
                                </select>
                                @error('puntuacion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Texto de la reseña --}}
                            <div class="mb-3">
                                <label for="texto" class="form-label">Tu Reseña</label>
                                <textarea name="texto" id="texto" rows="5"
                                    class="form-control @error('texto') is-invalid @enderror"
                                    placeholder="Escribe aquí tu opinión sobre este contenido...">{{ old('texto') }}</textarea>
                                @error('texto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Botón de Enviar --}}
                            <div class="d-grid">
                                <button type="submit" class="boton boton-primario btn-lg">Publicar Reseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection