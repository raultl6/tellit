@extends('layouts.master')

@section('titulo', 'Editar Perfil')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @endpush

    <div class="contenedor tarjeta-centrada-sm seccion-pagina">
        <div class="tarjeta">
            <h2 class="mb-4">Editar Perfil</h2>

            @if ($errors->any())
                <div class="alerta-error mb-4">
                    <ul class="lista-errores">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group texto-centrado">
                    <div class="foto-perfil perfil-avatar-grande">
                        <img id="avatar-preview" src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" alt="Avatar" class="img-avatar-redonda">
                    </div>
                    <label for="avatar" class="boton boton-contorno boton-sm" style="cursor: pointer;">
                        Cambiar foto de perfil
                    </label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

                <div class="form-group">
                    <label for="name" class="font-bold mb-2 etiqueta-formulario">Nombre de usuario</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="font-bold mb-2 etiqueta-formulario">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group separador-superior mt-4">
                    <h3 class="mb-2">Cambiar Contraseña (Opcional)</h3>
                    <label for="password" class="font-bold mb-2 etiqueta-formulario">Nueva contraseña</label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Déjalo en blanco si no quieres cambiarla">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="font-bold mb-2 etiqueta-formulario">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                </div>

                <div class="form-group flex justify-between mt-4">
                    <a href="{{ route('profile') }}" class="boton boton-contorno">Cancelar</a>
                    <button type="submit" class="boton boton-primario">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
@endsection
