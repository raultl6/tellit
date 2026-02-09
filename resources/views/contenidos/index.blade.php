@extends('layouts.master')

@section('titulo', 'Explorar')

@section('contenido')
    <div class="sidebar-layout">

        <aside class="sidebar">
            <div class="sidebar-box">
                <h3 class="filter-title">Filtros</h3>

                <div class="filter-group">
                    <label class="filter-label">Buscar</label>
                    <input type="text" placeholder="Título..." class="form-input">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Género</label>
                    <select class="form-select">
                        <option value="">Todos</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary btn-block">Aplicar</button>
            </div>
        </aside>

        <div class="content-area">
            <h3 class="section-title">Explorar</h3>

            <div class="grid grid-4">
                @foreach($contenidos as $contenido)
                    <a href="{{ route('contenidos.show', $contenido->slug) }}" class="card">

                        <div class="placeholder-img content-card-img"
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