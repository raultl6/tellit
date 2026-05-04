@extends('layouts.master')

@section('titulo', 'Editar Lista')

@section('contenido')
<div class="contenedor" style="margin-top: 40px;">
    <div class="tarjeta" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4">Editar Lista</h2>

        @if ($errors->any())
            <div class="alerta alerta-error mb-4">
                <ul>
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
                <label for="nombre" class="font-bold mb-2" style="display: block;">Nombre de la lista</label>
                <input type="text" id="nombre" name="nombre" class="form-input" value="{{ old('nombre', $lista->nombre) }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="descripcion" class="font-bold mb-2" style="display: block;">Descripción (Opcional)</label>
                <textarea id="descripcion" name="descripcion" class="form-input" rows="4">{{ old('descripcion', $lista->descripcion) }}</textarea>
            </div>

            <div class="flex justify-between items-center mt-4 pt-4" style="border-top: 1px solid #eee;">
                <a href="{{ route('listas.show', $lista) }}" class="text-gray" style="text-decoration: none;">Cancelar</a>
                <button type="submit" class="boton boton-primario">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
