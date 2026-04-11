@extends('layouts.master')

@section('titulo', 'Admin Reportes')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="caja-nav-admin">
            <a href="{{ route('admin.index') }}" class="boton boton-nav-admin">Títulos</a>
            <a href="{{ route('admin.users') }}" class="boton boton-nav-admin">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="boton boton-nav-admin">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="boton boton-nav-admin danger-active">Reportes ⚠️</a>
        </div>

        <div class="tarjeta">
            <h3 class="mb-4">Reportes Pendientes</h3>
            <table class="tabla-admin">
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
                            <button class="boton btn-neutral btn-sm">Ignorar</button>
                            <button class="boton btn-mint btn-sm">Borrar Reseña</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Comentario de <b>Troll22</b></td>
                        <td>Insultos / Ofensivo</td>
                        <td>Ana123</td>
                        <td>
                            <button class="boton btn-neutral btn-sm">Ignorar</button>
                            <button class="boton boton-primario btn-sm">Banear Usuario</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection