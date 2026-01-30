@extends('layouts.master')

@section('titulo', 'Categorías')

@section('contenido')
    <h2 class="text-center mb-4">Categorías</h2>

    <div class="grid grid-3">
        @foreach($categorias as $categoria)
            <a href="#" class="card text-center flex"
                style="height: 120px; justify-content: center; font-weight: bold; font-size: 1.2rem; background: #eff6ff; color: #333; text-decoration: none;">
                {{ strtoupper($categoria->nombre) }}
            </a>
        @endforeach
    </div>
@endsection