@extends('layouts.master')

@section('titulo', 'Editar Perfil')

@section('contenido')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <div class="contenedor" style="max-width: 600px; margin-top: 40px;">
        <div class="tarjeta">
            <h2 class="mb-4">Editar Perfil</h2>

            @if ($errors->any())
                <div class="alerta alerta-error mb-4 p-3" style="background: #fee2e2; color: #b91c1c; border-radius: 8px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group" style="text-align: center; margin-bottom: 30px;">
                    <div class="foto-perfil profile-avatar-large" style="margin: 0 auto 15px auto;">
                        <img id="avatar-preview" src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                    </div>
                    <label for="avatar" class="boton boton-contorno" style="cursor: pointer; font-size: 0.9rem;">
                        Cambiar foto de perfil
                    </label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

                <div class="form-group">
                    <label for="name" class="font-bold mb-2" style="display: block;">Nombre de usuario</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="font-bold mb-2" style="display: block;">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <h3 style="margin-bottom: 15px; font-size: 1.2rem;">Cambiar Contraseña (Opcional)</h3>
                    <label for="password" class="font-bold mb-2" style="display: block;">Nueva contraseña</label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Déjalo en blanco si no quieres cambiarla">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="font-bold mb-2" style="display: block;">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                </div>

                <div class="form-group flex justify-between" style="margin-top: 30px;">
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
