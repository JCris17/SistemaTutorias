<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TutoriaController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UserController;

// Rutas públicas
Route::get('/', [AuthController::class, 'showLanding'])->name('landingpage');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware(['auth.session'])->group(function () {
    
    // Solo para TUTOR
        Route::middleware(['role:tutor'])->group(function () {
        Route::get('/tutor', [TutorController::class, 'dashboard'])->name('tutor');
        
        // Rutas de tutorías para tutor
        Route::post('/tutorias', [TutoriaController::class, 'store'])->name('tutorias.store');
        Route::put('/tutorias/{id}', [TutoriaController::class, 'update'])->name('tutorias.update');
        Route::delete('/tutorias/{id}', [TutoriaController::class, 'destroy'])->name('tutorias.destroy');
    });

    // Solo para ESTUDIANTE
    Route::middleware(['role:estudiante'])->group(function () {
        Route::get('/estudiante', function () {
            return view('estudiante');
        })->name('estudiante');
    });

    // Solo para COORDINADOR
    Route::middleware(['role:coordinador'])->group(function () {
        Route::get('/coordinador', function () {
            return view('coordinador');
        })->name('coordinador');
        
        // Gestión de usuarios (solo coordinador)
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Ruta común para dashboard
    Route::get('/dashboard', function () {
        $user = session('user');
        return view('dashboard', compact('user'));
    })->name('dashboard');
});