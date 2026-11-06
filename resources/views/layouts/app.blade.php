<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Liga de Básquetbol')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/logo.svg') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-liga sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo Liga Básquetbol" width="34" height="34" class="me-2">
                Liga Básquetbol
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Mostrar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('estadisticas*') ? 'active' : '' }}" href="{{ url('/estadisticas') }}">
                                <i class="bi bi-bar-chart-line me-1"></i>Estadísticas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('equipos*') ? 'active' : '' }}" href="{{ url('/equipos') }}">
                                <i class="bi bi-shield-shaded me-1"></i>Equipos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('jugadores*') ? 'active' : '' }}" href="{{ url('/jugadores') }}">
                                <i class="bi bi-people me-1"></i>Jugadores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('partidos*') ? 'active' : '' }}" href="{{ url('/partidos') }}">
                                <i class="bi bi-calendar-event me-1"></i>Partidos
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-lg-center">
                        <li class="nav-item">
                            <span class="navbar-text me-lg-3">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i>Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer-liga mt-auto">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span><i class="bi bi-dribbble me-1"></i><strong>Liga Básquetbol</strong> — Gestión deportiva</span>
            <span class="small">Proyecto académico · Laravel + MySQL</span>
        </div>
    </footer>

    <script src="{{ asset('vendor/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
