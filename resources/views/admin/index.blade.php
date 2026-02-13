@extends('layouts.master')

@section('titulo', 'Admin Títulos')

@section('contenido')
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

            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Título</th>
                        <th style="padding: 10px;">Año</th>
                        <th style="padding: 10px;">Tipo</th>
                        <th style="padding: 10px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dummy Data for now -->
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">001</td>
                        <td style="padding: 10px;">The Matrix</td>
                        <td style="padding: 10px;">1999</td>
                        <td style="padding: 10px;">Película</td>
                        <td style="padding: 10px;">
                            <a href="#" style="color:var(--primary); margin-right:10px;">[Editar]</a>
                            <a href="#" style="color:var(--text-red);">[Borrar]</a>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">002</td>
                        <td style="padding: 10px;">Inception</td>
                        <td style="padding: 10px;">2010</td>
                        <td style="padding: 10px;">Película</td>
                        <td style="padding: 10px;">
                            <a href="#" style="color:var(--primary); margin-right:10px;">[Editar]</a>
                            <a href="#" style="color:var(--text-red);">[Borrar]</a>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">003</td>
                        <td style="padding: 10px;">Breaking Bad</td>
                        <td style="padding: 10px;">2008</td>
                        <td style="padding: 10px;">Serie</td>
                        <td style="padding: 10px;">
                            <a href="#" style="color:var(--primary); margin-right:10px;">[Editar]</a>
                            <a href="#" style="color:var(--text-red);">[Borrar]</a>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">004</td>
                        <td style="padding: 10px;">Stranger Things</td>
                        <td style="padding: 10px;">2016</td>
                        <td style="padding: 10px;">Serie</td>
                        <td style="padding: 10px;">
                            <a href="#" style="color:var(--primary); margin-right:10px;">[Editar]</a>
                            <a href="#" style="color:var(--text-red);">[Borrar]</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection