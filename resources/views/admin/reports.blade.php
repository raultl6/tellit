@extends('layouts.master')

@section('titulo', 'Admin Reportes')

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
            <a href="{{ route('admin.reports') }}" class="boton boton-nav-admin danger-active">Reportes ⚠️</a>
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
            <h3 class="mb-4">Reportes Pendientes</h3>
            <table class="tabla-admin">
                <thead>
                    <tr>
                        <th>Reportado</th>
                        <th>Motivo</th>
                        <th>Denunciante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportes as $reporte)
                        <tr>
                            <td>
                                @if(class_basename($reporte->reportable_type) === 'Resena')
                                    Reseña de <b>{{ $reporte->reportable->user->name ?? 'Usuario borrado' }}</b>
                                @else
                                    {{ class_basename($reporte->reportable_type) }} #{{ $reporte->reportable_id }}
                                @endif
                            </td>
                            <td>{{ $reporte->motivo }}</td>
                            <td>{{ $reporte->user->name ?? 'Anónimo' }}</td>
                            <td style="display: flex; gap: 5px;">
                                <form action="{{ route('admin.reports.resolve', $reporte->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="accion" value="ignorar">
                                    <button type="submit" class="boton btn-neutral btn-sm" style="padding: 4px 10px; font-size: 0.8rem;">Ignorar</button>
                                </form>
                                <form action="{{ route('admin.reports.resolve', $reporte->id) }}" method="POST" onsubmit="return confirm('¿Borrar el recurso de forma permanente?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="accion" value="borrar">
                                    <button type="submit" class="boton btn-mint btn-sm" style="padding: 4px 10px; font-size: 0.8rem;">Borrar Recurso</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay reportes pendientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $reportes->links() }}
            </div>
        </div>
    </div>
@endsection