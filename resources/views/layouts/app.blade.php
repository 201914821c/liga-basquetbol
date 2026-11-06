<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Liga de Básquetbol')</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}">
    <style>
        body { background-color: #f4f6f9; }
        .navbar-brand { font-weight: 700; letter-spacing: .5px; }
        .card { border: 0; }
        .table thead th { white-space: nowrap; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Liga Básquetbol</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Mostrar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('estadisticas*') ? 'active' : '' }}" href="{{ url('/estadisticas') }}">Estadísticas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('equipos*') ? 'active' : '' }}" href="{{ url('/equipos') }}">Equipos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('jugadores*') ? 'active' : '' }}" href="{{ url('/jugadores') }}">Jugadores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('partidos*') ? 'active' : '' }}" href="{{ url('/partidos') }}">Partidos</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-lg-center">
                        <li class="nav-item">
                            <span class="navbar-text me-lg-3">{{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
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

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('vendor/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
