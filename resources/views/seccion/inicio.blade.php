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

    <!-- Reseñas Recientes -->
    <h3 class="section-title">Reseñas Recientes</h3>
    @if($resenasRecientes->count() > 0)
        <div class="cuadricula cuadricula-3 mb-4">
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
        <p class="text-gray mb-4">Aún no hay reseñas en la plataforma. ¡Anímate a ser el primero!</p>
    @endif

    <div class="cuadricula cuadricula-3" style="margin-bottom: 5rem;">
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
            <a href="{{ route('contenidos.random') }}" class="boton boton-primario btn-block" style="display: inline-block;">Sorpréndeme</a>
        </div>
    </div>
@endsection