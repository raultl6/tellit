<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELLIT - Registro</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>

    <a href="{{ route('home') }}" class="auth-back-btn">
        ←
    </a>

    <main class="contenedor contenedor-acceso">
        <div class="tarjeta tarjeta-acceso">

            <div class="auth-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="auth-logo">
                <h1 class="titulo-sitio auth-title">TELLIT</h1>
                <p class="text-gray auth-subtitle">Únete a la comunidad</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group auth-form-group">
                    <label class="auth-label">Nombre de Usuario</label>
                    <input type="text" name="name" class="form-input auth-input" placeholder="Ej: Cinefilo23" required>
                </div>

                <div class="form-group auth-form-group">
                    <label class="auth-label">Email</label>
                    <input type="email" name="email" class="form-input auth-input" placeholder="ejemplo@correo.com"
                        required>
                </div>

                <div class="form-group auth-form-group">
                    <label class="auth-label">Contraseña</label>
                    <input type="password" name="password" class="form-input auth-input"
                        placeholder="Mínimo 8 caracteres" required>
                </div>

                <div class="form-group auth-form-group">
                    <label class="auth-label">Confirmar
                        Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-input auth-input"
                        placeholder="Repite la contraseña" required>
                </div>

                @if ($errors->any())
                    <div class="alerta-error mb-2">
                        <ul class="lista-errores">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="boton boton-primario btn-block auth-btn mt-4">Crear Cuenta</button>
            </form>

            <div class="auth-footer">
                <p class="text-gray text-small">¿Ya tienes cuenta? <a href="{{ route('login') }}"
                        class="auth-link">Inicia sesión</a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>