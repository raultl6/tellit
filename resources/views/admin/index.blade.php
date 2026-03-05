@extends('layouts.master')

@section('titulo', 'Admin Títulos')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div
            style="background: #1f2937; padding: 15px; border-radius: 6px; margin-bottom: 20px; display: flex; gap: 10px; overflow-x: auto;">
            <a href="{{ route('admin.index') }}" class="btn"
                style="background: #374151; color: white; border: 1px solid transparent;">Títulos</a>

            <a href="{{ route('admin.users') }}" class="btn"
                style="background: none; color: white; border: 1px solid transparent;">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="btn"
                style="background: none; color: white; border: 1px solid transparent;">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="btn"
                style="background: none; color: white; border: 1px solid transparent;">Reportes ⚠️</a>
        </div>

        <div class="card">
            <div class="flex justify-between mb-4">
                <h3 style="margin:0;">Gestión de Contenido</h3>
                <button class="btn btn-mint" style="padding: 8px 15px; font-size: 0.9rem;">+ Nuevo Título</button>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Año</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <td>001</td>
                        <td>The Matrix</td>
                        <td>1999</td>
                        <td>Película</td>
                        <td>
                            <a href="#" class="action-link-edit">[Editar]</a>
                            <a href="#" class="action-link-delete">[Borrar]</a>
                        </td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Inception</td>
                        <td>2010</td>
                        <td>Película</td>
                        <td>
                            <a href="#" class="action-link-edit">[Editar]</a>
                            <a href="#" class="action-link-delete">[Borrar]</a>
                        </td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Breaking Bad</td>
                        <td>2008</td>
                        <td>Serie</td>
                        <td>
                            <a href="#" class="action-link-edit">[Editar]</a>
                            <a href="#" class="action-link-delete">[Borrar]</a>
                        </td>
                    </tr>
                    <tr>
                        <td>004</td>
                        <td>Stranger Things</td>
                        <td>2016</td>
                        <td>Serie</td>
                        <td>
                            <a href="#" class="action-link-edit">[Editar]</a>
                            <a href="#" class="action-link-delete">[Borrar]</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection