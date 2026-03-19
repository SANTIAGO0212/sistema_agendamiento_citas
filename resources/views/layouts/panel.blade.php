<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de citas - Reservali</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
</head>

<body>
    <div id="overlay" class="overlay"></div>
    <div class="layout">

        {{-- SIDEBAR --}}
        <aside id="sidebar" class="sidebar">

            <div class="brand">
                <i class='bx bx-wind'></i>
                <span>Reservali</span>
            </div>

            <ul class="nav-links">

                <li class="active">
                    <a href="#">
                        <i class='bx bx-home'></i>
                        <span>Panel</span>
                    </a>
                </li>

                <li class="submenu-toggle">
                    <a href="#">
                        <i class='bx bx-user'></i>
                        <span>Usuarios</span>
                        <i class='bx bx-chevron-right arrow'></i>
                    </a>

                    <a href="#">
                        <i class='bx bx-group'></i>
                        <span>Especialistas</span>
                        <i class='bx bx-chevron-right arrow'></i>
                    </a>

                    <a href="#">
                        <i class='bx bx-calendar-event'></i>
                        <span>Citas</span>
                        <i class='bx bx-chevron-right arrow'></i>
                    </a>

                    <a href="#">
                        <i class='bx bx-store'></i>
                        <span>Sucursales</span>
                        <i class='bx bx-chevron-right arrow'></i>
                    </a>

                    <a href="#">
                        <i class='bx bx-bookmark-alt'></i>
                        <span>Servicios</span>
                        <i class='bx bx-chevron-right arrow'></i>
                    </a>
                </li>
            </ul>
        </aside>

        {{-- MAIN --}}
        <div class="main">

            {{-- NAVBAR --}}
            <nav class="topbar">

                <i class='bx bx-menu toggle-sidebar'></i>

                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Buscar">
                </div>

                <div class="theme">
                    <button id="toggleTheme" class="theme-btn">
                        <i class='bx bx-moon icon-moon'></i>
                    </button>
                </div>
                <!--<div class="topbar-right">
                    <div class="profile">
                        <img src="https://i.pravatar.cc/40" alt="">
                        <div>
                            <strong>Pauline Seitz</strong>
                            <small>Diseñador web</small>
                        </div>
                    </div>
                </div>-->

                <div class="topbar-right">
                    <div class="profile dropdown">
                        <div class="d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                            <img src="https://i.pravatar.cc/40" alt="">
                            <div class="ms-2">
                                <strong>Pauline Seitz</strong>
                                <small class="d-block">Diseñador web</small>
                            </div>
                        </div>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <!--<li><a class="dropdown-item" href="#">Configuración</a></li>-->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content p-4">
                @yield('content')
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/panel.js') }}"></script>
</body>

</html>