@extends('layouts.master')

@section('titulo', 'Explorar')

@section('contenido')
    <div class="sidebar-layout">

        <aside class="sidebar">
            <div class="sidebar-box">
                <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Filtros</h3>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 5px;">Buscar</label>
                    <input type="text" placeholder="Título..." class="form-input">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 5px;">Género</label>
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

                        <div class="placeholder-img"
                            style="background-image: url('{{ $contenido->imagen_url }}'); background-size: cover; background-position: center;">
                            @if(!$contenido->imagen_url) IMG @endif
                        </div>

                        <h4>{{ $contenido->titulo }}</h4>

                        <div
                            style="font-size: 0.8rem; color: #666; display: flex; justify-content: space-between; margin-top: 5px;">
                            <span>{{ $contenido->año }}</span>
                            <span style="color: #fbbf24;">★ {{ $contenido->puntuacion }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection