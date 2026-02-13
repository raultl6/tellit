@extends('layouts.master')

@section('titulo', 'Admin Usuarios')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="admin-nav-container">
            <a href="{{ route('admin.index') }}" class="btn admin-nav-btn">Títulos</a>
            <a href="{{ route('admin.users') }}" class="btn admin-nav-btn active">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="btn admin-nav-btn">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="btn admin-nav-btn">Reportes ⚠️</a>
        </div>

        <div class="card">
            <h3 class="mb-4">Gestión de Usuarios</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>U01</td>
                        <td>UsuarioEjemplo</td>
                        <td>user@mail.com</td>
                        <td><span class="text-green">Activo</span></td>
                        <td><a href="#" class="action-link-delete">[Banear]</a></td>
                    </tr>
                    <tr>
                        <td>U02</td>
                        <td>Cinefilo99</td>
                        <td>cine@mail.com</td>
                        <td><span class="text-green">Activo</span></td>
                        <td><a href="#" class="action-link-delete">[Banear]</a></td>
                    </tr>
                    <tr>
                        <td>U03</td>
                        <td>Spammer123</td>
                        <td>spam@mail.com</td>
                        <td><span class="text-red">Baneado</span></td>
                        <td><a href="#" class="text-gray">[Desbanear]</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection