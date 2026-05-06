@extends('layouts.master')

@section('titulo', $lista->nombre)

@section('contenido')
<div class="contenedor seccion-pagina">
    <div class="mb-4">
        <div class="flex justify-between items-end">
            <div>
                <h2>{{ $lista->nombre }}</h2>
                @if($lista->descripcion)
                    <p class="text-gray mt-2">{{ $lista->descripcion }}</p>
                @endif
                <div class="mt-2 text-small text-gray">
                    Creada por {{ $lista->user->name }} • {{ $lista->contenidos->count() }} elementos
                </div>
            </div>
            
            @if(Auth::id() === $lista->user_id)
                <div class="flex gap-2">
                    <a href="{{ route('listas.edit', $lista) }}" class="boton enlace-sin-decoracion">Editar</a>
                    <form action="{{ route('listas.destroy', $lista) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres borrar esta lista?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="boton text-red">Eliminar</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alerta-exito mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($lista->contenidos->count() > 0)
        <div class="cuadricula cuadricula-4">
            @foreach($lista->contenidos as $contenido)
                <div class="tarjeta text-center">
                    <a href="{{ route('contenidos.show', $contenido->slug) }}" class="enlace-sin-decoracion">
                        @if($contenido->imagen_url)
                            <img src="{{ Str::startsWith($contenido->imagen_url, 'http') ? $contenido->imagen_url : asset('storage/' . $contenido->imagen_url) }}" alt="{{ $contenido->titulo }}" class="poster-lista">
                        @else
                            <div class="poster-lista-placeholder">
                                <span>Sin Poster</span>
                            </div>
                        @endif
                        <h3 class="titulo-lista-item">{{ $contenido->titulo }}</h3>
                        <p class="text-gray text-small">{{ $contenido->año }}</p>
                    </a>

                    @if(Auth::id() === $lista->user_id)
                        <form action="{{ route('listas.toggle', $lista) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="contenido_id" value="{{ $contenido->id }}">
                            <button type="submit" class="boton text-red text-small w-full btn-sm">Quitar de la lista</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="tarjeta text-center p-3">
            <h3 class="mb-2">Esta lista está vacía</h3>
            <p class="text-gray">Explora nuestro catálogo y añade películas o series a esta lista.</p>
            <a href="{{ route('contenidos.index') }}" class="boton boton-primario mt-3">Explorar Catálogo</a>
        </div>
    @endif
</div>
@endsection
