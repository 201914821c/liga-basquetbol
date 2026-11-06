<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\PartidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');

    Route::resource('equipos', EquipoController::class);
    Route::resource('jugadores', JugadorController::class)
        ->parameters(['jugadores' => 'jugador']);

    Route::resource('partidos', PartidoController::class)
        ->parameters(['partidos' => 'partido']);
    Route::get('partidos/{partido}/resultado', [PartidoController::class, 'resultado'])
        ->name('partidos.resultado');
    Route::patch('partidos/{partido}/resultado', [PartidoController::class, 'guardarResultado'])
        ->name('partidos.guardarResultado');
});
