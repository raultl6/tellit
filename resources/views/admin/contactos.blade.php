@extends('layouts.master')

@section('titulo', 'Admin Contactos')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Panel de Administración</h2>

        <div class="caja-nav-admin">
            <a href="{{ route('admin.index') }}" class="boton boton-nav-admin">Títulos</a>
            <a href="{{ route('admin.users') }}" class="boton boton-nav-admin">Usuarios</a>
            <a href="{{ route('admin.reviews') }}" class="boton boton-nav-admin">Reseñas</a>
            <a href="{{ route('admin.contactos') }}" class="boton boton-nav-admin danger-active">Contacto ✉️</a>
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
            <h3 class="mb-4">Mensajes de Contacto</h3>
            <table class="tabla-admin" style="width: 100%; text-align: left; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd;">Usuario</th>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd;">Asunto</th>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd;">Mensaje</th>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contactos as $contacto)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">
                                <strong>{{ $contacto->nombre }}</strong><br>
                                <small style="color: #6b7280;">{{ $contacto->email }}</small>
                            </td>
                            <td style="padding: 10px;">{{ $contacto->asunto }}</td>
                            <td style="padding: 10px; max-width: 300px; word-wrap: break-word;">{{ $contacto->mensaje }}</td>
                            <td style="padding: 10px;">
                                <div style="display: flex; gap: 5px;">
                                    <form action="{{ route('admin.contactos.destroy', $contacto->id) }}" method="POST" onsubmit="return confirm('¿Borrar este mensaje de forma permanente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="boton btn-mint btn-sm" style="padding: 4px 10px; font-size: 0.8rem; background: #ef4444;">Borrar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center" style="padding: 20px;">No hay mensajes de contacto.</td>
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