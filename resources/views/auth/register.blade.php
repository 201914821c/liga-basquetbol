@extends('layouts.app')

@section('title', 'Registro de usuario')

@section('content')
    <div class="auth-page">
        <div class="row justify-content-center w-100">
            <div class="col-lg-10 col-xl-9">
                <div class="card auth-card">
                    <div class="row g-0">
                        <div class="col-md-5 auth-visual d-none d-md-flex">
                            <div>
                                <img src="{{ asset('img/logo.svg') }}" alt="Logo Liga Básquetbol" width="56" height="56" class="mb-3">
                                <h2>Únete a la liga</h2>
                                <p class="mb-4">
                                    Crea tu cuenta y empieza a organizar la competición: equipos, plantillas y calendario.
                                </p>
                                <p class="small mb-1"><i class="bi bi-check-circle me-2"></i>Fácil de administrar</p>
                                <p class="small mb-0"><i class="bi bi-check-circle me-2"></i>Diseñado para clubes</p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="auth-form">
                                <h1 class="h3 section-title mb-2">Crear cuenta</h1>
                                <p class="text-muted mb-4">Regístrate para gestionar la liga de básquetbol.</p>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Nombre completo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                                   class="form-control" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Correo electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" id="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="form-text">Mínimo 8 caracteres.</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="bi bi-person-plus me-1"></i>Registrarme
                                    </button>
                                </form>

                                <p class="text-center mt-3 mb-0">
                                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
