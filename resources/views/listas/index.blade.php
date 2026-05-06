@extends('layouts.master')

@section('titulo', 'Mis Listas')

@section('contenido')
<div class="contenedor seccion-pagina">
    <div class="flex justify-between items-center mb-4">
        <h2>Tus Listas</h2>
        <a href="{{ route('listas.create') }}" class="boton boton-primario">+ Crear Nueva Lista</a>
    </div>

    @if(session('success'))
        <div class="alerta-exito mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="cuadricula cuadricula-3">
        @forelse($listas as $lista)
            <a href="{{ route('listas.show', $lista) }}" class="tarjeta enlace-sin-decoracion">
                <h3>{{ $lista->nombre }}</h3>
                <p class="text-gray text-small mt-2">{{ Str::limit($lista->descripcion, 60) }}</p>
                
                <div class="mt-3 flex justify-between items-center">
                    <span class="etiqueta">{{ $lista->contenidos_count }} títulos</span>
                </div>
            </a>
        @empty
            <div class="tarjeta text-center" style="grid-column: span 3;">
                <p class="text-gray">Aún no has creado ninguna lista.</p>
                <a href="{{ route('listas.create') }}" class="boton boton-primario mt-3">Crear mi primera lista</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
