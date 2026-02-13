@extends('layouts.master')

@section('titulo', 'Admin Reseñas')

@section('contenido')
    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div
            style="background: #1f2937; padding: 15px; border-radius: 6px; margin-bottom: 20px; display: flex; gap: 10px; overflow-x: auto;">
            <a href="{{ route('admin.index') }}" class="btn" style="background: none; color: white;">Títulos</a>
            <a href="{{ route('admin.users') }}" class="btn" style="background: none; color: white;">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="btn" style="background: #374151; color: white;">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="btn"
                style="background: none; color: white; border: 1px solid transparent;">Reportes ⚠️</a>
        </div>

        <div class="card">
            <h3 class="mb-4">Últimas Reseñas Publicadas</h3>
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px;">Fecha</th>
                        <th style="padding: 10px;">Usuario</th>
                        <th style="padding: 10px;">Película</th>
                        <th style="padding: 10px;">Rating</th>
                        <th style="padding: 10px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">Hoy, 10:00</td>
                        <td style="padding: 10px;">PedroP</td>
                        <td style="padding: 10px;">Barbie</td>
                        <td style="padding: 10px;">⭐⭐⭐⭐⭐</td>
                        <td style="padding: 10px;"><a href="#" style="color:var(--text-red);">[Borrar]</a></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">Ayer, 22:30</td>
                        <td style="padding: 10px;">MariaL</td>
                        <td style="padding: 10px;">Oppenheimer</td>
                        <td style="padding: 10px;">⭐⭐⭐⭐</td>
                        <td style="padding: 10px;"><a href="#" style="color:var(--text-red);">[Borrar]</a></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">Ayer, 18:15</td>
                        <td style="padding: 10px;">Critic007</td>
                        <td style="padding: 10px;">Flash</td>
                        <td style="padding: 10px;">⭐</td>
                        <td style="padding: 10px;"><a href="#" style="color:var(--text-red);">[Borrar]</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection