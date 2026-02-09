<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELLIT - Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body style="background-color: #f3f4f6;">

    <a href="{{ route('home') }}" class="auth-back-btn"> ← </a>

    <main class="container auth-container">
        <div class="card auth-card">

            <div class="auth-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="auth-logo">
                <h1 class="site-title auth-title">TELLIT</h1>
                <p class="text-gray auth-subtitle">Bienvenido de nuevo</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group auth-form-group">
                    <label class="auth-label">Email</label>
                    <input type="email" name="email" class="form-input auth-input" placeholder="ejemplo@correo.com"
                        required value="{{ old('email') }}">
                </div>

                <div class="form-group auth-form-group">
                    <label class="auth-label">Contraseña</label>
                    <input type="password" name="password" class="form-input auth-input" placeholder="Tu contraseña"
                        required>
                </div>

                @if ($errors->any())
                    <div class="auth-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-block auth-btn">
                    Iniciar Sesión
                </button>
            </form>

            <div class="auth-footer">
                <p class="text-gray text-small">¿No tienes cuenta? <a href="{{ route('register') }}"
                        class="auth-link">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>