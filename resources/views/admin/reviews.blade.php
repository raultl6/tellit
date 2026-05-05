@extends('layouts.master')

@section('titulo', 'Admin Reseñas')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="caja-nav-admin">
            <a href="{{ route('admin.index') }}" class="boton boton-nav-admin">Títulos</a>
            <a href="{{ route('admin.users') }}" class="boton boton-nav-admin">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="boton boton-nav-admin active">Reseñas</a>
            <a href="{{ route('admin.contactos') }}" class="boton boton-nav-admin">Contacto ✉️</a>
        </div>

        @if(session('success'))
            <div class="alerta alerta-exito mb-4 p-3 mt-4" style="background: #10b981; color: white; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alerta alerta-error mb-4 p-3 mt-4" style="background: #ef4444; color: white; border-radius: 4px;">
                {{ session('error') }}
            </div>
        @endif

        <div class="tarjeta mt-4">
            <h3 class="mb-4">Últimas Reseñas Publicadas</h3>
            <table class="tabla-admin">
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
                    @forelse ($resenas as $resena)
                        <tr>
                            <td>{{ $resena->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $resena->user->name ?? 'Usuario borrado' }}</td>
                            <td>{{ Str::limit($resena->contenido->titulo ?? 'Contenido borrado', 20) }}</td>
                            <td>{{ str_repeat('⭐', $resena->puntuacion) }}</td>
                            <td>
                                <form action="{{ route('admin.reviews.destroy', $resena->id) }}" method="POST" onsubmit="return confirm('¿Confirmar el borrado de esta reseña?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-link-delete" style="background: none; border: none; cursor: pointer; padding: 0;">[Borrar]</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay reseñas publicadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $resenas->links() }}
            </div>
        </div>
    </div>
@endsection