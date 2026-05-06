@extends('layouts.master')

@section('titulo', 'Mi Perfil')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @endpush

    <div class="perfil-disposicion-lateral">

        <aside class="perfil-barra-lateral">
            <div class="caja-lateral-perfil">
                <div class="foto-perfil perfil-avatar-grande">
                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" alt="Avatar" class="img-avatar-redonda">
                </div>
                <h3>{{ $user->name }}</h3>
                <a href="{{ route('profile.edit') }}" class="perfil-enlace-editar">Editar Perfil</a>

                <div class="perfil-acciones">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="boton btn-block perfil-boton-logout">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="perfil-area-contenido">

            <div class="tarjeta mb-4">
                <div class="perfil-cabecera-seccion">
                    <h3>Tus Listas</h3>
                    <div>
                        <a href="{{ route('listas.index') }}" class="perfil-enlace-ver-todas">Ver todas...</a>
                        <a href="{{ route('listas.create') }}" class="boton-crear-lista">+ Crear</a>
                    </div>
                </div>
                <div class="cuadricula cuadricula-2">
                    @forelse($listas as $lista)
                        <a href="{{ route('listas.show', $lista) }}" class="tarjeta enlace-sin-decoracion {{ $loop->index % 2 == 0 ? 'tarjeta-lista-terror' : 'tarjeta-lista-favs' }}">
                            <h4 class="m-0">{{ $lista->nombre }}</h4>
                            <p class="mt-2 m-0">{{ $lista->contenidos_count }} elementos</p>
                        </a>
                    @empty
                        <div class="tarjeta text-center" style="grid-column: span 2; background: #f9fafb;">
                            <p class="text-gray m-0">Aún no tienes listas. ¡Crea una para organizar tu contenido!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tarjeta">
                <h3 class="perfil-titulo-historial">Historial de Reseñas</h3>

                <div class="perfil-lista-resenas">
                    @forelse($resenas as $resena)
                        <a href="{{ route('contenidos.show', $resena->contenido->slug) }}" class="enlace-sin-decoracion">
                            <div class="perfil-resena-item">
                                <div class="perfil-resena-poster">
                                    @if($resena->contenido->imagen_url)
                                        <img src="{{ Str::startsWith($resena->contenido->imagen_url, 'http') ? $resena->contenido->imagen_url : asset('storage/' . $resena->contenido->imagen_url) }}" alt="Poster" class="img-avatar-redonda" style="border-radius: 4px;">
                                    @else
                                        IMG
                                    @endif
                                </div>
                                <div class="perfil-resena-contenido">
                                    <div class="perfil-resena-cabecera">
                                        <h4 class="perfil-resena-titulo">{{ $resena->contenido->titulo }}</h4>
                                        <span class="text-yellow text-small">{{ str_repeat('⭐', $resena->puntuacion) }}{{ str_repeat('☆', 5 - $resena->puntuacion) }}</span>
                                    </div>
                                    <p class="text-gray text-small perfil-resena-texto">"{{ Str::limit($resena->comentario, 100) }}"</p>
                                    <div class="perfil-resena-fecha">{{ $resena->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray">No has escrito ninguna reseña todavía.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection