@extends('layouts.master')

@section('titulo', 'Admin Reseñas')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="admin-nav-container">
            <a href="{{ route('admin.index') }}" class="btn admin-nav-btn">Títulos</a>
            <a href="{{ route('admin.users') }}" class="btn admin-nav-btn">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="btn admin-nav-btn active">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="btn admin-nav-btn">Reportes ⚠️</a>
        </div>

        <div class="card">
            <h3 class="mb-4">Últimas Reseñas Publicadas</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Película</th>
                        <th>Rating</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hoy, 10:00</td>
                        <td>PedroP</td>
                        <td>Barbie</td>
                        <td>⭐⭐⭐⭐⭐</td>
                        <td><a href="#" class="action-link-delete">[Borrar]</a></td>
                    </tr>
                    <tr>
                        <td>Ayer, 22:30</td>
                        <td>MariaL</td>
                        <td>Oppenheimer</td>
                        <td>⭐⭐⭐⭐</td>
                        <td><a href="#" class="action-link-delete">[Borrar]</a></td>
                    </tr>
                    <tr>
                        <td>Ayer, 18:15</td>
                        <td>Critic007</td>
                        <td>Flash</td>
                        <td>⭐</td>
                        <td><a href="#" class="action-link-delete">[Borrar]</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection