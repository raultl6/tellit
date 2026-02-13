@extends('layouts.master')

@section('titulo', 'Admin Reportes')

@section('contenido')
    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div
            style="background: #1f2937; padding: 15px; border-radius: 6px; margin-bottom: 20px; display: flex; gap: 10px; overflow-x: auto;">
            <a href="{{ route('admin.index') }}" class="btn" style="background: none; color: white;">Títulos</a>
            <a href="{{ route('admin.users') }}" class="btn" style="background: none; color: white;">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="btn" style="background: none; color: white;">Reseñas</a>
            <a href="{{ route('admin.reports') }}" class="btn"
                style="background: #dc2626; color: white; border: 1px solid #dc2626;">Reportes ⚠️</a>
        </div>

        <div class="card">
            <h3 class="mb-4">Reportes Pendientes</h3>
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px;">Reportado</th>
                        <th style="padding: 10px;">Motivo</th>
                        <th style="padding: 10px;">Denunciante</th>
                        <th style="padding: 10px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">Reseña de <b>UserX</b> en "Matrix"</td>
                        <td style="padding: 10px;">Spoiler sin avisar</td>
                        <td style="padding: 10px;">UsuarioEjemplo</td>
                        <td style="padding: 10px;">
                            <button class="btn"
                                style="padding: 5px 10px; font-size: 0.8rem; background: #eee;">Ignorar</button>
                            <button class="btn btn-mint" style="padding: 5px 10px; font-size: 0.8rem;">Borrar
                                Reseña</button>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">Comentario de <b>Troll22</b></td>
                        <td style="padding: 10px;">Insultos / Ofensivo</td>
                        <td style="padding: 10px;">Ana123</td>
                        <td style="padding: 10px;">
                            <button class="btn"
                                style="padding: 5px 10px; font-size: 0.8rem; background: #eee;">Ignorar</button>
                            <button class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;">Banear
                                Usuario</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection