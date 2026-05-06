@extends('layouts.master')

@section('titulo', 'Admin Títulos')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div class="padding-admin">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        @if(session('success'))
            <div class="alerta-exito-admin mb-4 p-3">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alerta-error-admin mb-4 p-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="caja-nav-admin">
            <a href="{{ route('admin.index') }}" class="boton boton-nav-admin active">Títulos</a>
            <a href="{{ route('admin.users') }}" class="boton boton-nav-admin">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="boton boton-nav-admin">Reseñas</a>
            <a href="{{ route('admin.contactos') }}" class="boton boton-nav-admin">Contacto ✉️</a>
        </div>

        <div class="tarjeta">
            <div class="flex justify-between mb-4">
                <h3 class="m-0">Gestión de Contenido</h3>
                <a href="{{ route('admin.contenidos.create') }}" class="boton btn-mint boton-sm">+ Nuevo Título</a>
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
                            <td>
                                <form action="{{ route('admin.contenidos.destroy', $contenido->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas borrar este título?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="enlace-accion-borrar">[Borrar]</button>
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