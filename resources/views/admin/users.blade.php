@extends('layouts.master')

@section('titulo', 'Admin Usuarios')

@section('contenido')
    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div
            style="background: #1f2937; padding: 15px; border-radius: 6px; margin-bottom: 20px; display: flex; gap: 10px; overflow-x: auto;">
            <a href="{{ route('admin.index') }}" class="btn"
                style="background: none; color: white; border: 1px solid transparent;">Títulos</a>
            <a href="{{ route('admin.users') }}" class="btn" style="background: #374151; color: white;">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="btn"
                style="background: none; color: white; border: 1px solid transparent;">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="btn"
                style="background: none; color: white; border: 1px solid transparent;">Reportes ⚠️</a>
        </div>

        <div class="card">
            <h3 class="mb-4">Gestión de Usuarios</h3>
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Usuario</th>
                        <th style="padding: 10px;">Email</th>
                        <th style="padding: 10px;">Estado</th>
                        <th style="padding: 10px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">U01</td>
                        <td style="padding: 10px;">UsuarioEjemplo</td>
                        <td style="padding: 10px;">user@mail.com</td>
                        <td style="padding: 10px;"><span style="color: green;">Activo</span></td>
                        <td style="padding: 10px;"><a href="#" style="color:var(--text-red);">[Banear]</a></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">U02</td>
                        <td style="padding: 10px;">Cinefilo99</td>
                        <td style="padding: 10px;">cine@mail.com</td>
                        <td style="padding: 10px;"><span style="color: green;">Activo</span></td>
                        <td style="padding: 10px;"><a href="#" style="color:var(--text-red);">[Banear]</a></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">U03</td>
                        <td style="padding: 10px;">Spammer123</td>
                        <td style="padding: 10px;">spam@mail.com</td>
                        <td style="padding: 10px;"><span style="color: red;">Baneado</span></td>
                        <td style="padding: 10px;"><a href="#" style="color:var(--text-gray);">[Desbanear]</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection