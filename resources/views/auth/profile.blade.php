@extends('layouts.master')

@section('titulo', 'Mi Perfil')

@section('contenido')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <div class="profile-sidebar-layout">

        <aside class="profile-sidebar">
            <div class="caja-lateral-perfil">
                <div class="foto-perfil profile-avatar-large">
                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" alt="Avatar"
                        style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                </div>
                <h3>{{ $user->name }}</h3>
                <a href="#" class="profile-edit-link">Editar Perfil</a> <!-- Link placeholder -->

                <div class="profile-actions">
                    <button class="boton boton-primario btn-block mb-2">Mis Listas</button>

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
                    <a href="#" class="create-list-btn">+ Crear</a> <!-- Link placeholder -->
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
                    <!-- Static examples from HTML for now -->
                    <div class="profile-review-item">
                        <div class="profile-review-poster">IMG</div>
                        <div class="profile-review-content">
                            <div class="profile-review-header">
                                <h4 class="profile-review-title">The Matrix</h4>
                                <span class="text-yellow text-small">⭐⭐⭐⭐☆</span>
                            </div>
                            <p class="text-gray text-small profile-review-text">"Un clásico absoluto de la ciencia
                                ficción..."</p>
                            <div class="profile-review-date">Hace 2 días</div>
                        </div>
                    </div>

                    <div class="profile-review-item">
                        <div class="profile-review-poster">IMG</div>
                        <div class="profile-review-content">
                            <div class="profile-review-header">
                                <h4 class="profile-review-title">Barbie</h4>
                                <span class="text-yellow text-small">⭐⭐⭐⭐⭐</span>
                            </div>
                            <p class="text-gray text-small profile-review-text">"Sorprendentemente profunda y divertida."
                            </p>
                            <div class="profile-review-date">Hace 1 semana</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection