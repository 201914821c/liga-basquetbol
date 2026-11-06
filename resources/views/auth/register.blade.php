@extends('layouts.app')

@section('title', 'Registro de usuario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">Crear cuenta</h1>
                    <p class="text-muted">Regístrate para gestionar la liga de básquetbol.</p>

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
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <div class="form-text">Mínimo 8 caracteres.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrarme</button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
