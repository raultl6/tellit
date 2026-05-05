@extends('layouts.master')

@section('titulo', 'Contáctanos')

@section('contenido')
<div class="contenedor" style="margin-top: 40px; margin-bottom: 60px;">
    <div class="tarjeta" style="max-width: 800px; margin: 0 auto; padding: 40px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 class="mb-2">Ponte en contacto con nosotros</h1>
            <p class="text-gray">¿Tienes alguna pregunta, sugerencia o problema? ¡Nos encantaría escucharte!</p>
        </div>

        <div style="max-width: 600px; margin: 0 auto;">
            <!-- Formulario -->
            <div>
                <h3 class="mb-4">Envíanos un Mensaje</h3>
                
                @if(session('success'))
                    <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contacto.enviar') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label for="nombre" class="font-bold mb-2" style="display: block;">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" class="form-input" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="font-bold mb-2" style="display: block;">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="asunto" class="font-bold mb-2" style="display: block;">Asunto</label>
                        <select id="asunto" name="asunto" class="form-input" required>
                            <option value="">Selecciona un asunto...</option>
                            <option value="Soporte Técnico">Soporte Técnico</option>
                            <option value="Sugerencias">Sugerencias</option>
                            <option value="Reportar un problema">Reportar un problema</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="mensaje" class="font-bold mb-2" style="display: block;">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" class="form-input" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="boton boton-primario" style="width: 100%;">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
