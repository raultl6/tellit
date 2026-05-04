@extends('layouts.master')

@section('titulo', 'Mi Perfil')

@section('contenido')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}?v={{ time() }}">

    <div class="profile-sidebar-layout">

        <aside class="profile-sidebar">
            <div class="caja-lateral-perfil">
                <div class="foto-perfil profile-avatar-large">
                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" alt="Avatar"
                        style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                </div>
                <h3>{{ $user->name }}</h3>
                <a href="{{ route('profile.edit') }}" class="profile-edit-link">Editar Perfil</a>

                <div class="profile-actions">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="boton btn-block profile-logout-btn">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="profile-content-area">

            <div class="tarjeta mb-4">
                <div class="profile-section-header">
                    <h3>Tus Listas</h3>
                    <div>
                        <a href="#" style="text-decoration: none; color: #6b7280; margin-right: 15px; font-size: 0.9rem;">Ver todas...</a>
                        <a href="#" class="create-list-btn">+ Crear</a>
                    </div>
                </div>
                <div class="cuadricula cuadricula-2">
                    <a href="#" class="tarjeta list-card-terror">
                        <h4>Terror Favoritas</h4>
                        <p>5 elementos</p>
                    </a>
                    <a href="#" class="tarjeta list-card-favs">
                        <h4>Favoritas</h4>
                        <p>10 elementos</p>
                    </a>
                </div>
            </div>

            <div class="tarjeta">
                <h3 class="profile-history-title">Historial de Reseñas</h3>

                <div class="profile-reviews-list">
                    @forelse($resenas as $resena)
                        <a href="{{ route('contenidos.show', $resena->contenido->slug) }}" class="profile-review-link" style="text-decoration: none; color: inherit; display: block;">
                            <div class="profile-review-item">
                                <div class="profile-review-poster">
                                    @if($resena->contenido->imagen_url)
                                        <img src="{{ Str::startsWith($resena->contenido->imagen_url, 'http') ? $resena->contenido->imagen_url : asset('storage/' . $resena->contenido->imagen_url) }}" alt="Poster" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                    @else
                                        IMG
                                    @endif
                                </div>
                                <div class="profile-review-content">
                                    <div class="profile-review-header">
                                        <h4 class="profile-review-title">{{ $resena->contenido->titulo }}</h4>
                                        <span class="text-yellow text-small">{{ str_repeat('⭐', $resena->puntuacion) }}{{ str_repeat('☆', 5 - $resena->puntuacion) }}</span>
                                    </div>
                                    <p class="text-gray text-small profile-review-text">"{{ Str::limit($resena->comentario, 100) }}"</p>
                                    <div class="profile-review-date">{{ $resena->created_at->diffForHumans() }}</div>
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