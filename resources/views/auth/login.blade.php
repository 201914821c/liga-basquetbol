@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="auth-page">
        <div class="row justify-content-center w-100">
            <div class="col-lg-10 col-xl-9">
                <div class="card auth-card">
                    <div class="row g-0">
                        <div class="col-md-5 auth-visual d-none d-md-flex">
                            <div>
                                <img src="{{ asset('img/logo.svg') }}" alt="Logo Liga Básquetbol" width="56" height="56" class="mb-3">
                                <h2>Vive la liga</h2>
                                <p class="mb-4">
                                    Controla equipos, jugadores, partidos y la tabla de posiciones desde un solo lugar.
                                </p>
                                <p class="small mb-1"><i class="bi bi-check-circle me-2"></i>Resultados al instante</p>
                                <p class="small mb-0"><i class="bi bi-check-circle me-2"></i>Clasificación automática</p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="auth-form">
                                <h1 class="h3 section-title mb-2">Iniciar sesión</h1>
                                <p class="text-muted mb-4">Accede para administrar la liga de básquetbol.</p>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Correo electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                                   class="form-control" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" id="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">Recordarme</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                                    </button>
                                </form>

                                <div class="alert alert-warning small mt-4 mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Cuenta demo: <strong>admin@liga.test</strong> / <strong>password</strong>
                                </div>

                                <p class="text-center mt-3 mb-0">
                                    ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
