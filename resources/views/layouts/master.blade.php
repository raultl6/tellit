<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELLIT - @yield('titulo')</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
    @stack('css')
</head>

<body>
    <header>
        <div class="contenedor cabecera-contenido">
            <div class="cabecera-izq">
                <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img"></a>
                <button onclick="toggleMenu()" class="boton-menu">☰</button>
                <a href="{{ url('/') }}" class="titulo-sitio">TELLIT</a>
            </div>
            <div id="menuDesplegableGlobal" class="menu-desplegable">
                <a href="{{ url('/') }}" class="elemento-menu">🏠 Inicio</a>
                <a href="{{ route('contenidos.index') }}" class="elemento-menu">🔍 Explorar</a>
                <a href="{{ route('listas.index') }}" class="elemento-menu">📑 Mis Listas</a>
                
                <div class="separador-menu"></div>
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('admin.index') }}" class="elemento-menu enlace-admin">⚙️ Admin</a>
                @endif
            </div>
            <div class="cabecera-der">
                @if(!request()->routeIs('home'))
                <form action="{{ route('contenidos.index') }}" method="GET" class="contenedor-busqueda">
                    <input type="text" name="query" placeholder="Buscar..." class="input-busqueda" value="{{ request('query') }}">
                    <button type="submit" class="icono-busqueda">🔍</button>
                </form>
                @endif
                @auth
                    <div class="cabecera-usuario contenedor-avatar-usuario"
                        onclick="document.getElementById('menuUsuario').classList.toggle('show')">
                        <div class="info-usuario">
                            <strong>{{ Auth::user()->name }}</strong>
                        </div>
                        <div class="foto-perfil contenedor-avatar">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                                alt="Avatar" class="img-avatar">
                        </div>

                        <!-- Menú desplegable del usuario -->
                        <div id="menuUsuario" class="menu-desplegable menu-usuario">
                            <a href="{{ route('profile') }}" class="elemento-menu">👤 Mi Perfil</a>
                            <form action="{{ route('logout') }}" method="POST" class="formulario-logout">
                                @csrf
                                <button type="submit" class="elemento-menu boton-logout">
                                    🚪 Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="boton boton-primario boton-login-cabecera">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="contenedor">
        @yield('contenido')
    </main>

    <footer>
        <div class="contenedor footer-grid">
            <div>
                <h3 class="footer-titulo">TELLIT</h3>
                <p class="footer-copyright">© 2026. Todos los derechos reservados.</p>
                <p class="footer-texto-tmdb">
                    Datos proporcionados por <a href="https://www.themoviedb.org/" target="_blank" class="footer-enlace-tmdb">TMDB</a>.
                </p>
            </div>
            <div>
                <h4 class="footer-titulo">Enlaces</h4>
                <a href="{{ route('contacto') }}" class="footer-enlace">Contacto</a>
                <a href="{{ route('contenidos.index') }}" class="footer-enlace">Explorar Catálogo</a>
            </div>
            <div>
                <h4 class="footer-titulo">Social</h4>
                <div class="footer-redes">
                    <a href="#" class="enlace-social">
                        <img src="{{ asset('img/twitter.png') }}" alt="Twitter" width="24" height="24">
                    </a>
                    <a href="#" class="enlace-social">
                        <img src="{{ asset('img/instagram.png') }}" alt="Instagram" width="24" height="24">
                    </a>
                    <a href="https://github.com/raultl6/tellit" target="_blank" class="enlace-social">
                        <img src="{{ asset('img/github.png') }}" alt="GitHub" width="24" height="24">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMenu() { document.getElementById('menuDesplegableGlobal').classList.toggle('show'); }
        document.addEventListener('click', function (e) {
            // Cerrar menú principal
            if (!document.getElementById('menuDesplegableGlobal').contains(e.target) && !document.querySelector('.boton-menu').contains(e.target)) {
                document.getElementById('menuDesplegableGlobal').classList.remove('show');
            }
            // Cerrar menú de usuario
            const userDropdown = document.getElementById('menuUsuario');
            const userHeader = document.querySelector('.cabecera-usuario');
            if (userDropdown && userHeader && !userDropdown.contains(e.target) && !userHeader.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>

</html>