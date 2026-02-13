@extends('layouts.master')

@section('titulo', 'Admin Reportes')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="admin-nav-container">
            <a href="{{ route('admin.index') }}" class="btn admin-nav-btn">Títulos</a>
            <a href="{{ route('admin.users') }}" class="btn admin-nav-btn">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="btn admin-nav-btn">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="btn admin-nav-btn danger-active">Reportes ⚠️</a>
        </div>

        <div class="card">
            <h3 class="mb-4">Reportes Pendientes</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Reportado</th>
                        <th>Motivo</th>
                        <th>Denunciante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Reseña de <b>UserX</b> en "Matrix"</td>
                        <td>Spoiler sin avisar</td>
                        <td>UsuarioEjemplo</td>
                        <td>
                            <button class="btn btn-neutral btn-sm">Ignorar</button>
                            <button class="btn btn-mint btn-sm">Borrar Reseña</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Comentario de <b>Troll22</b></td>
                        <td>Insultos / Ofensivo</td>
                        <td>Ana123</td>
                        <td>
                            <button class="btn btn-neutral btn-sm">Ignorar</button>
                            <button class="btn btn-primary btn-sm">Banear Usuario</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection