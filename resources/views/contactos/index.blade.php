@extends('layouts.master')

@section('titulo', 'Contáctanos')

@section('contenido')
<div class="contenedor seccion-pagina">
    <div class="tarjeta tarjeta-centrada-md">
        <div class="texto-centrado">
            <h1 class="mb-2">Ponte en contacto con nosotros</h1>
            <p class="text-gray">¿Tienes alguna pregunta, sugerencia o problema? ¡Nos encantaría escucharte!</p>
        </div>

        <div class="tarjeta-centrada">
            <h3 class="mb-4">Envíanos un Mensaje</h3>
            
            @if(session('success'))
                <div class="alerta-exito mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contacto.enviar') }}" method="POST">
                @csrf
                
                <div class="form-group mb-4">
                    <label for="nombre" class="font-bold mb-2 etiqueta-formulario">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-input" required>
                </div>

                <div class="form-group mb-4">
                    <label for="email" class="font-bold mb-2 etiqueta-formulario">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="form-group mb-4">
                    <label for="asunto" class="font-bold mb-2 etiqueta-formulario">Asunto</label>
                    <select id="asunto" name="asunto" class="form-input" required>
                        <option value="">Selecciona un asunto...</option>
                        <option value="Soporte Técnico">Soporte Técnico</option>
                        <option value="Sugerencias">Sugerencias</option>
                        <option value="Reportar un problema">Reportar un problema</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="mensaje" class="font-bold mb-2 etiqueta-formulario">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" class="form-input" rows="5" required></textarea>
                </div>

                <button type="submit" class="boton boton-primario w-full">Enviar Mensaje</button>
            </form>
        </div>
    </div>
</div>
@endsection
