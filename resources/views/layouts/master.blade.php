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
                <a href="#" class="menu-item">🔍 Explorar</a>
                <a href="#" class="menu-item">📂 Categorías</a>
                <a href="#" class="menu-item">📑 Mis Listas</a>

                <a href="#" class="menu-item" style="color: var(--primary);">🔐 Login / Registro</a>

                <div style="border-top:1px solid #eee; margin: 5px 0;"></div>
                <a href="#" class="menu-item" style="font-size:0.8rem; color:#888;">⚙️ Admin</a>
            </div>
            <div class="header-right">
                <div class="search-container">
                    <input type="text" placeholder="Buscar..." class="search-input">
                    <a href="#" class="search-icon-small">🔍</a>
                </div>
                <a href="#" class="user-header">
                    <div class="user-info"><strong>Usuario</strong></div>
                    <div class="avatar">👤</div>
                </a>
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
            if (!document.getElementById('dropdownMenu').contains(e.target) && !document.querySelector('.menu-btn').contains(e.target)) {
                document.getElementById('dropdownMenu').classList.remove('show');
            }
        });
    </script>
</body>

</html>