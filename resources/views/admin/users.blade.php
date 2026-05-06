@extends('layouts.master')

@section('titulo', 'Admin Usuarios')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div class="padding-admin">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="caja-nav-admin">
            <a href="{{ route('admin.index') }}" class="boton boton-nav-admin">Títulos</a>
            <a href="{{ route('admin.users') }}" class="boton boton-nav-admin active">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="boton boton-nav-admin">Reseñas</a>
            <a href="{{ route('admin.contactos') }}" class="boton boton-nav-admin">Contacto ✉️</a>
        </div>

        @if(session('success'))
            <div class="alerta-exito-admin mb-4 p-3 mt-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alerta-error-admin mb-4 p-3 mt-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="tarjeta mt-4">
            <h3 class="mb-4">Gestión de Usuarios</h3>
            <table class="tabla-admin">
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
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if($usuario->is_banned)
                                    <span class="text-red">Baneado</span>
                                @else
                                    <span class="text-green">Activo</span>
                                @endif
                            </td>
                            <td>
                                @if($usuario->id !== auth()->id())
                                    <div class="celda-acciones">
                                        <form action="{{ route('admin.users.ban', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Confirmar acción sobre este usuario?');" class="m-0">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="enlace-accion-borrar">
                                                @if($usuario->is_banned)
                                                    <span class="text-gray">[Desbanear]</span>
                                                @else
                                                    [Banear]
                                                @endif
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('ATENCIÓN: ¿Estás seguro de que quieres eliminar a este usuario permanentemente? Esta acción no se puede deshacer e implicará borrar todo su contenido asociado (reseñas, listas, etc).');" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="enlace-accion-borrar" style="color: #dc2626;">
                                                [Eliminar]
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray texto-tu">(Tú)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
@endsection