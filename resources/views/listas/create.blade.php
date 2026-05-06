@extends('layouts.master')

@section('titulo', 'Crear Lista')

@section('contenido')
<div class="contenedor seccion-pagina">
    <div class="tarjeta tarjeta-centrada-sm">
        <h2 class="mb-4">Crear Nueva Lista</h2>

        @if ($errors->any())
            <div class="alerta-error mb-4">
                <ul class="lista-errores">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('listas.store') }}" method="POST">
            @csrf
            
            <div class="form-group mb-4">
                <label for="nombre" class="font-bold mb-2 etiqueta-formulario">Nombre de la lista</label>
                <input type="text" id="nombre" name="nombre" class="form-input" value="{{ old('nombre') }}" required placeholder="Ej: Mis películas favoritas">
            </div>

            <div class="form-group mb-4">
                <label for="descripcion" class="font-bold mb-2 etiqueta-formulario">Descripción (Opcional)</label>
                <textarea id="descripcion" name="descripcion" class="form-input" rows="4" placeholder="¿De qué trata esta lista?">{{ old('descripcion') }}</textarea>
            </div>

            <div class="flex justify-between items-center mt-4 pt-4 separador-superior">
                <a href="{{ route('listas.index') }}" class="text-gray enlace-sin-decoracion">Cancelar</a>
                <button type="submit" class="boton boton-primario">Guardar Lista</button>
            </div>
        </form>
    </div>
</div>
@endsection
