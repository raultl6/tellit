<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELLIT - Registro</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body style="background-color: #fff;">

    <a href="{{ route('home') }}"
        style="position: absolute; top: 30px; left: 30px; font-size: 2rem; text-decoration: none; color: #333; cursor: pointer;">
        ←
    </a>

    <main class="container" style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
        <div class="card"
            style="width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 30px; border-radius: 10px;">

            <div style="text-align: center; margin-bottom: 30px;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo"
                    style="width: 60px; height: 60px; object-fit: contain; margin-bottom: 10px;">
                <h1 class="site-title" style="font-size: 2rem; margin: 0;">TELLIT</h1>
                <p class="text-gray" style="margin-top: 5px;">Únete a la comunidad</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf <div class="form-group" style="margin-bottom: 15px;">
                    <label style="font-weight: bold; font-size: 0.9rem; margin-bottom:5px; display:block;">Nombre de
                        Usuario</label>
                    <input type="text" name="name" class="form-input" placeholder="Ej: Cinefilo23" required
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="font-weight: bold; font-size: 0.9rem; margin-bottom:5px; display:block;">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="ejemplo@correo.com" required
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label
                        style="font-weight: bold; font-size: 0.9rem; margin-bottom:5px; display:block;">Contraseña</label>
                    <input type="password" name="password" class="form-input" placeholder="Mínimo 8 caracteres" required
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="font-weight: bold; font-size: 0.9rem; margin-bottom:5px; display:block;">Confirmar
                        Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-input"
                        placeholder="Repite la contraseña" required
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                @if ($errors->any())
                    <div style="color: red; font-size: 0.9rem; margin-bottom: 15px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-block"
                    style="margin-top: 20px; width: 100%; padding: 12px; background-color: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer;">Crear
                    Cuenta</button>
            </form>

            <div style="border-top: 1px solid #eee; margin: 30px 0 10px 0; padding-top: 20px; text-align: center;">
                <p class="text-gray text-small">¿Ya tienes cuenta? <a href="#" style="color: #3b82f6;">Inicia sesión</a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>