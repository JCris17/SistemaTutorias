<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TutoriaController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CoordinadorController;

// Rutas públicas
Route::get('/', [AuthController::class, 'showLanding'])->name('landingpage');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    
    // Solo para TUTOR
    Route::middleware(['role:tutor'])->group(function () {
        Route::get('/tutor', [TutorController::class, 'dashboard'])->name('tutor');
        Route::get('/tutor/dashboard', [TutorController::class, 'dashboard'])->name('tutor.dashboard');
        Route::get('/tutor/solicitudes', [TutorController::class, 'solicitudes'])->name('tutor.solicitudes');
        Route::get('/tutor/solicitudes/data', [TutorController::class, 'getSolicitudesData'])->name('tutor.solicitudes.data');
        Route::post('/tutor/solicitudes/{id}/tomar', [TutorController::class, 'tomarSolicitud'])->name('tutor.solicitudes.tomar');
        Route::post('/tutor/solicitudes/{id}/responder', [TutorController::class, 'responderSolicitud'])->name('tutor.solicitudes.responder');
        
        // Tutorías
        Route::resource('/tutorias', TutoriaController::class);
        Route::post('/tutorias', [TutoriaController::class, 'store'])->name('tutorias.store');
        Route::put('/tutorias/{id}', [TutoriaController::class, 'update'])->name('tutorias.update');
        Route::delete('/tutorias/{id}', [TutoriaController::class, 'destroy'])->name('tutorias.destroy');
        
        // Asistencia
        Route::post('/asistencia/registrar', [TutorController::class, 'registrarAsistencia'])->name('asistencia.registrar');
        
        // Horario
        Route::post('/horario/update', [TutorController::class, 'actualizarHorario'])->name('horario.update');
        
        // Recursos
        Route::post('/recursos', [TutorController::class, 'subirRecurso'])->name('recursos.subir');
        Route::get('/recursos/{id}/download', [TutorController::class, 'downloadRecurso'])->name('recursos.download');
        
        // Estudiantes
        Route::get('/estudiantes', [TutorController::class, 'estudiantes'])->name('estudiantes');
    });

     // Rutas para ESTUDIANTE
    Route::middleware(['role:estudiante'])->group(function () {
        Route::get('/estudiante', [EstudianteController::class, 'dashboard'])->name('estudiante');
        Route::get('/estudiante/dashboard', [EstudianteController::class, 'dashboard'])->name('estudiante.dashboard');
        Route::get('/estudiante/tutorias', [EstudianteController::class, 'misTutorias'])->name('estudiante.tutorias');
        Route::get('/estudiante/inscribirse', [EstudianteController::class, 'inscribirse'])->name('estudiante.inscribirse');
        Route::post('/estudiante/inscribir-tutoria/{tutoria}', [EstudianteController::class, 'inscribirTutoria'])->name('estudiante.inscribir-tutoria');
        Route::delete('/estudiante/tutorias/cancelar/{tutoria}', [EstudianteController::class, 'cancelarTutoria'])->name('estudiante.tutorias.cancelar');
        Route::get('/estudiante/progreso', [EstudianteController::class, 'progreso'])->name('estudiante.progreso');
        Route::get('/estudiante/recursos', [EstudianteController::class, 'recursos'])->name('estudiante.recursos');
        Route::get('/estudiante/solicitudes', [EstudianteController::class, 'solicitudes'])->name('estudiante.solicitudes');
        Route::post('/estudiante/solicitudes/crear', [EstudianteController::class, 'crearSolicitud'])->name('estudiante.solicitudes.crear');
        Route::get('/estudiante/recursos/{id}/download', [EstudianteController::class, 'downloadRecurso'])->name('estudiante.recursos.download');
    });
    // Rutas para COORDINADOR
    Route::middleware(['role:coordinador'])->group(function () {
        Route::get('/coordinador', [CoordinadorController::class, 'dashboard'])->name('coordinador');
        Route::get('/coordinador/dashboard', [CoordinadorController::class, 'dashboard'])->name('coordinador.dashboard');
        Route::get('/coordinador/tutorias/{id}/estudiantes', [CoordinadorController::class, 'obtenerEstudiantesTutoria'])->name('coordinador.tutorias.estudiantes');
        Route::get('/coordinador/reportes', [CoordinadorController::class, 'reportes'])->name('coordinador.reportes');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        // Gestión de tutorías
        Route::get('/coordinador/tutorias', [CoordinadorController::class, 'gestionTutorias'])->name('coordinador.tutorias');
        Route::post('/coordinador/tutorias', [CoordinadorController::class, 'crearTutoria'])->name('coordinador.tutorias.crear');
        Route::put('/coordinador/tutorias/{id}', [CoordinadorController::class, 'actualizarTutoria'])->name('coordinador.tutorias.actualizar');
        Route::delete('/coordinador/tutorias/{id}', [CoordinadorController::class, 'eliminarTutoria'])->name('coordinador.tutorias.eliminar');
        
        // Gestión de estudiantes
        Route::get('/coordinador/estudiantes', [CoordinadorController::class, 'gestionEstudiantes'])->name('coordinador.estudiantes');
        Route::post('/coordinador/estudiantes', [CoordinadorController::class, 'crearEstudiante'])->name('coordinador.estudiantes.crear');
        
        // Gestión de tutores
        Route::get('/coordinador/tutores', [CoordinadorController::class, 'gestionTutores'])->name('coordinador.tutores');
        Route::post('/coordinador/tutores', [CoordinadorController::class, 'crearTutor'])->name('coordinador.tutores.crear');
        
        // Control de asistencia
        Route::get('/coordinador/asistencia', [CoordinadorController::class, 'controlAsistencia'])->name('coordinador.asistencia');
        Route::post('/coordinador/asistencia', [CoordinadorController::class, 'registrarAsistencia'])->name('coordinador.asistencia.registrar');
        
        // Reportes
        Route::post('/coordinador/reportes', [CoordinadorController::class, 'generarReportes'])->name('coordinador.reportes.generar');
    });
        Route::post('/recursos', [TutorController::class, 'subirRecurso'])->name('recursos.store');
        Route::get('/recursos/{id}/download', [TutorController::class, 'downloadRecurso'])->name('recursos.download');  
        Route::get('/debug-recursos', [TutorController::class, 'debugRecursos'])->name('debug.recursos');
    // Ruta común para dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    })->name('dashboard');
});