@extends('layouts.master')

@section('titulo', 'Explorar')

@section('contenido')
    <div class="sidebar-layout">

        <aside class="barra-lateral">
            <form action="{{ route('contenidos.index') }}" method="GET" class="caja-lateral">
                <h3 class="filter-title">Filtros</h3>

                <div class="filter-group">
                    <label class="filter-label">Buscar</label>
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="Título..." class="form-input">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Género</label>
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

        <div class="content-area">
            <h3 class="section-title">Explorar</h3>

            <div class="cuadricula cuadricula-4">
                @foreach($contenidos as $contenido)
                    <a href="{{ route('contenidos.show', $contenido->slug) }}" class="tarjeta">

                        <div class="imagen-relleno imagen-tarjeta-contenido"
                            style="background-image: url('{{ $contenido->imagen_url }}');">
                            @if(!$contenido->imagen_url) IMG @endif
                        </div>

                        <h4>{{ $contenido->titulo }}</h4>

                        <div class="content-card-meta">
                            <span>{{ $contenido->año }}</span>
                            <span class="card-rating">★ {{ $contenido->puntuacion }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection