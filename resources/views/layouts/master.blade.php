<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELLIT - @yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <header>
        <div class="container header-content">
            <div class="header-left">
                <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img"></a>
                <button onclick="toggleMenu()" class="menu-btn">☰</button>
                <a href="{{ url('/') }}" class="site-title">TELLIT</a>
            </div>
            <div id="dropdownMenu" class="dropdown-menu">
                <a href="{{ url('/') }}" class="menu-item">🏠 Inicio</a>
                <a href="{{ route('contenidos.index') }}" class="menu-item">🔍 Explorar</a>
                <a href="#" class="menu-item">📑 Mis Listas</a>

                <!-- Login/Registro removed from here as requested -->

                <div style="border-top:1px solid #eee; margin: 5px 0;"></div>
                <a href="#" class="menu-item" style="font-size:0.8rem; color:#888;">⚙️ Admin</a>
            </div>
            <div class="header-right">
                <div class="search-container">
                    <input type="text" placeholder="Buscar..." class="search-input">
                    <a href="#" class="search-icon-small">🔍</a>
                </div>
                @auth
                    <div class="user-header"
                        style="position: relative; display: flex; align-items: center; gap: 10px; cursor: pointer;"
                        onclick="document.getElementById('userDropdown').classList.toggle('show')">
                        <div class="user-info" style="text-align: right;">
                            <strong>{{ Auth::user()->name }}</strong>
                        </div>
                        <div class="avatar" style="width: 35px; height: 35px; border-radius: 50%; overflow: hidden;">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                                alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <!-- User Dropdown -->
                        <div id="userDropdown" class="dropdown-menu" style="top: 50px; right: 0; min-width: 150px;">
                            <a href="#" class="menu-item">👤 Mi Perfil</a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="menu-item"
                                    style="width: 100%; text-align: left; background: none; border: none; font-family: inherit; font-size: inherit; cursor: pointer; color: #ef4444;">
                                    🚪 Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary"
                        style="padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="container">
        @yield('contenido')
    </main>

    <footer>
        <div class="container footer-grid">
            <div>
                <h3 style="margin-bottom: 10px;">TELLIT</h3>
                <p style="font-size: 0.9rem; color: #9CA3AF;">© 2023. Todos los derechos reservados.</p>
            </div>
            <div>
                <h4 style="margin-bottom: 10px;">Enlaces</h4>
                <a href="#" class="footer-link">Contacto</a>
                <a href="#" class="footer-link">Sobre Nosotros</a>
                <a href="#" class="footer-link">Admin</a>
            </div>
            <div>
                <h4 style="margin-bottom: 10px;">Social</h4>
                <p style="color: #9CA3AF;">Tw | Ig | Fb</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMenu() { document.getElementById('dropdownMenu').classList.toggle('show'); }
        document.addEventListener('click', function (e) {
            // Close main menu
            if (!document.getElementById('dropdownMenu').contains(e.target) && !document.querySelector('.menu-btn').contains(e.target)) {
                document.getElementById('dropdownMenu').classList.remove('show');
            }
            // Close user dropdown
            const userDropdown = document.getElementById('userDropdown');
            const userHeader = document.querySelector('.user-header');
            if (userDropdown && userHeader && !userDropdown.contains(e.target) && !userHeader.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    </script>
</body>

</html>