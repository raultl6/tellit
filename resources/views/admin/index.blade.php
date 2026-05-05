@extends('layouts.master')

@section('titulo', 'Admin Títulos')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        @if(session('success'))
            <div class="alerta alerta-exito mb-4 p-3" style="background: #10b981; color: white; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alerta alerta-error mb-4 p-3" style="background: #ef4444; color: white; border-radius: 4px;">
                {{ session('error') }}
            </div>
        @endif

        <div
            style="background: #1f2937; padding: 15px; border-radius: 6px; margin-bottom: 20px; display: flex; gap: 10px; overflow-x: auto;">
            <a href="{{ route('admin.index') }}" class="boton"
                style="background: #374151; color: white; border: 1px solid transparent;">Títulos</a>

            <a href="{{ route('admin.users') }}" class="boton"
                style="background: none; color: white; border: 1px solid transparent;">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="boton"
                style="background: none; color: white; border: 1px solid transparent;">Reseñas</a>
            <a href="{{ route('admin.contactos') }}" class="boton"
                style="background: none; color: white; border: 1px solid transparent;">Contacto ✉️</a>
        </div>

        <div class="tarjeta">
            <div class="flex justify-between mb-4">
                <h3 style="margin:0;">Gestión de Contenido</h3>
                <a href="{{ route('admin.contenidos.create') }}" class="boton btn-mint" style="padding: 8px 15px; font-size: 0.9rem;">+ Nuevo Título</a>
            </div>

            <table class="tabla-admin">
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
                    @forelse ($contenidos as $contenido)
                        <tr>
                            <td>{{ $contenido->id }}</td>
                            <td>{{ $contenido->titulo }}</td>
                            <td>{{ $contenido->año ?? 'N/A' }}</td>
                            <td>{{ ucfirst($contenido->tipo) }}</td>
                            <td style="display: flex; gap: 10px;">
                                <form action="{{ route('admin.contenidos.destroy', $contenido->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas borrar este título?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-link-delete" style="background: none; border: none; cursor: pointer; padding: 0;">[Borrar]</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay títulos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $contenidos->links() }}
            </div>
        </div>
    </div>
@endsection