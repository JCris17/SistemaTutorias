<?php

use App\Http\Controllers\TutoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Para API, usar el mismo middleware 'auth' que en web.php
Route::middleware(['auth'])->group(function () {
    // Rutas para tutorías
    Route::get('/tutorias', [TutoriaController::class, 'apiIndex']);
    Route::post('/tutorias', [TutoriaController::class, 'apiStore']);
    Route::get('/tutorias/{tutoria}', [TutoriaController::class, 'apiShow']);
    Route::put('/tutorias/{tutoria}', [TutoriaController::class, 'apiUpdate']);
    Route::delete('/tutorias/{tutoria}', [TutoriaController::class, 'apiDestroy']);
    
    // Rutas para usuarios (coordinador)
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::post('/usuarios', [UserController::class, 'store']);
    Route::get('/usuarios/{id}', [UserController::class, 'show']);
    Route::put('/usuarios/{id}', [UserController::class, 'update']);
    Route::put('/usuarios/{id}/desactivar', [UserController::class, 'desactivar']);
    
    // Rutas del dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});