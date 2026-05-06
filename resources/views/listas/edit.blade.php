@extends('layouts.master')

@section('titulo', 'Editar Lista')

@section('contenido')
<div class="contenedor seccion-pagina">
    <div class="tarjeta tarjeta-centrada-sm">
        <h2 class="mb-4">Editar Lista</h2>

        @if ($errors->any())
            <div class="alerta-error mb-4">
                <ul class="lista-errores">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('listas.update', $lista) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-4">
                <label for="nombre" class="font-bold mb-2 etiqueta-formulario">Nombre de la lista</label>
                <input type="text" id="nombre" name="nombre" class="form-input" value="{{ old('nombre', $lista->nombre) }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="descripcion" class="font-bold mb-2 etiqueta-formulario">Descripción (Opcional)</label>
                <textarea id="descripcion" name="descripcion" class="form-input" rows="4">{{ old('descripcion', $lista->descripcion) }}</textarea>
            </div>

            <div class="flex justify-between items-center separador-superior">
                <a href="{{ route('listas.show', $lista) }}" class="text-gray enlace-sin-decoracion">Cancelar</a>
                <button type="submit" class="boton boton-primario">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
