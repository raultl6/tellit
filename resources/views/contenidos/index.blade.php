@extends('layouts.master')

@section('titulo', 'Explorar')

@section('contenido')
    <div class="disposicion-lateral seccion-pagina">

        <aside class="barra-lateral">
            <form action="{{ route('contenidos.index') }}" method="GET" class="caja-lateral">
                <h3 class="filtro-titulo">Filtros</h3>

                <div class="filtro-grupo">
                    <label class="filtro-etiqueta">Buscar</label>
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="Título..." class="form-input">
                </div>

                <div class="filtro-grupo">
                    <label class="filtro-etiqueta">Género</label>
                    <select name="categoria" class="form-select">
                        <option value="">Todos</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="boton boton-primario btn-block">Aplicar</button>
            </form>
        </aside>

        <div class="area-contenido">
            <h3 class="titulo-seccion">Explorar</h3>

            <div class="cuadricula cuadricula-4">
                @foreach($contenidos as $contenido)
                    <a href="{{ route('contenidos.show', $contenido->slug) }}" class="tarjeta">

                        <div class="imagen-relleno imagen-tarjeta-contenido"
                            style="background-image: url('{{ $contenido->imagen_url }}');">
                            @if(!$contenido->imagen_url) IMG @endif
                        </div>

                        <h4>{{ $contenido->titulo }}</h4>

                        <div class="meta-tarjeta-contenido">
                            <span>{{ $contenido->año }}</span>
                            @if($contenido->resenas->count() > 0)
                                <span class="puntuacion-tarjeta">★ {{ number_format($contenido->resenas->avg('puntuacion'), 1) }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection