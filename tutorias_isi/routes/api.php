<?php

use App\Http\Controllers\TutoriaController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Rutas API (si necesitas API separada)
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/tutorias', [TutoriaController::class, 'apiIndex']);
    Route::post('/tutorias', [TutoriaController::class, 'apiStore']);
    Route::get('/tutorias/{tutoria}', [TutoriaController::class, 'apiShow']);
    Route::put('/tutorias/{tutoria}', [TutoriaController::class, 'apiUpdate']);
    Route::delete('/tutorias/{tutoria}', [TutoriaController::class, 'apiDestroy']);
    
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Rutas WEB para el tutor
Route::middleware(['auth', 'role:tutor'])->prefix('tutor')->group(function () {
    Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('tutor.dashboard');
    Route::resource('/tutorias', TutoriaController::class);
    Route::post('/asistencia', [TutorController::class, 'registrarAsistencia'])->name('asistencia.registrar');
    Route::put('/horario', [TutorController::class, 'actualizarHorario'])->name('horario.update');
    Route::post('/recursos', [TutorController::class, 'subirRecurso'])->name('recursos.subir');
    Route::get('/estudiantes', [TutorController::class, 'estudiantes'])->name('estudiantes');
});

// Rutas para coordinador (si las necesitas)
Route::middleware(['auth', 'role:coordinador'])->prefix('coordinador')->group(function () {
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::post('/usuarios', [UserController::class, 'store']);
    Route::get('/usuarios/{id}', [UserController::class, 'show']);
    Route::put('/usuarios/{id}', [UserController::class, 'update']);
    Route::put('/usuarios/{id}/desactivar', [UserController::class, 'desactivar']);
});