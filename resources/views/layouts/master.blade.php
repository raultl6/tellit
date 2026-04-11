<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELLIT - @yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
    @stack('css')
</head>

<body>
    <header>
        <div class="contenedor header-content">
            <div class="header-left">
                <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img"></a>
                <button onclick="toggleMenu()" class="menu-btn">☰</button>
                <a href="{{ url('/') }}" class="site-title">TELLIT</a>
            </div>
            <div id="menuDesplegableGlobal" class="menu-desplegable">
                <a href="{{ url('/') }}" class="menu-item">🏠 Inicio</a>
                <a href="{{ route('contenidos.index') }}" class="menu-item">🔍 Explorar</a>
                <a href="#" class="menu-item">📑 Mis Listas</a>

                <!-- Login/Registro removed from here as requested -->

                <div class="dropdown-divider"></div>
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('admin.index') }}" class="menu-item admin-link">⚙️ Admin</a>
                @endif
            </div>
            <div class="header-right">
                <div class="search-container">
                    <input type="text" placeholder="Buscar..." class="search-input">
                    <a href="#" class="search-icon-small">🔍</a>
                </div>
                @auth
                    <div class="cabecera-usuario user-header-container"
                        onclick="document.getElementById('menuUsuario').classList.toggle('show')">
                        <div class="user-info" style="text-align: right;">
                            <strong>{{ Auth::user()->name }}</strong>
                        </div>
                        <div class="foto-perfil user-avatar-container">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                                alt="Avatar" class="user-avatar-img">
                        </div>

                        <!-- User Dropdown -->
                        <div id="menuUsuario" class="menu-desplegable user-dropdown-menu">
                            <a href="{{ route('profile') }}" class="menu-item">👤 Mi Perfil</a>
                            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                @csrf
                                <button type="submit" class="menu-item logout-btn">
                                    🚪 Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="boton boton-primario login-btn-header">
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
                <h3 class="footer-title">TELLIT</h3>
                <p class="footer-copyright">© 2023. Todos los derechos reservados.</p>
            </div>
            <div>
                <h4 class="footer-title">Enlaces</h4>
                <a href="#" class="footer-link">Contacto</a>
                <a href="#" class="footer-link">Sobre Nosotros</a>                
            </div>
            <div>
                <h4 class="footer-title">Social</h4>
                <p class="footer-social-text">Tw | Ig | Fb</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMenu() { document.getElementById('menuDesplegableGlobal').classList.toggle('show'); }
        document.addEventListener('click', function (e) {
            // Close main menu
            if (!document.getElementById('menuDesplegableGlobal').contains(e.target) && !document.querySelector('.menu-btn').contains(e.target)) {
                document.getElementById('menuDesplegableGlobal').classList.remove('show');
            }
            // Close user dropdown
            const userDropdown = document.getElementById('menuUsuario');
            const userHeader = document.querySelector('.cabecera-usuario');
            if (userDropdown && userHeader && !userDropdown.contains(e.target) && !userHeader.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    </script>
</body>

</html>