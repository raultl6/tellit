@extends('layouts.master')

@section('titulo', 'Admin Contactos')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div class="padding-admin">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="caja-nav-admin">
            <a href="{{ route('admin.index') }}" class="boton boton-nav-admin">Títulos</a>
            <a href="{{ route('admin.users') }}" class="boton boton-nav-admin">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="boton boton-nav-admin">Reseñas</a>
            <a href="{{ route('admin.contactos') }}" class="boton boton-nav-admin danger-active">Contacto ✉️</a>
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
            <h3 class="mb-4">Mensajes de Contacto</h3>
            <table class="tabla-admin">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contactos as $contacto)
                        <tr>
                            <td>
                                <strong>{{ $contacto->nombre }}</strong><br>
                                <small class="email-secundario">{{ $contacto->email }}</small>
                            </td>
                            <td>{{ $contacto->asunto }}</td>
                            <td class="celda-mensaje">{{ $contacto->mensaje }}</td>
                            <td>
                                <form action="{{ route('admin.contactos.destroy', $contacto->id) }}" method="POST" onsubmit="return confirm('¿Borrar este mensaje de forma permanente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="boton boton-borrar-contacto btn-sm">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-3">No hay mensajes de contacto.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $contactos->links() }}
            </div>
        </div>
    </div>
@endsection