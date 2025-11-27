<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Tutorías - Panel del Tutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-guindo: #800020;
            --dark-guindo: #660019;
            --light-guindo: #990025;
            --lighter-guindo: #f9f0f2;
            --accent-gold: #d4af37;
            --text-dark: #333333;
            --text-light: #ffffff;
            --gray-light: #f8f9fa;
            --gray-medium: #e9ecef;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--primary-guindo);
            color: var(--text-light);
            transition: all 0.3s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            font-size: 1.2rem;
            margin-bottom: 0;
            font-weight: 700;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .nav-link {
            color: var(--text-light);
            padding: 12px 20px;
            border-left: 4px solid transparent;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--accent-gold);
            color: var(--text-light);
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .top-navbar {
            background-color: var(--text-light);
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .top-navbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-guindo);
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .content-area {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
        }
        
        .page-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-medium);
        }
        
        .page-title {
            color: var(--primary-guindo);
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .card-header {
            background-color: var(--lighter-guindo);
            border-bottom: 1px solid var(--gray-medium);
            padding: 15px 20px;
            font-weight: 600;
            color: var(--primary-guindo);
            border-radius: 10px 10px 0 0 !important;
        }
        
        .btn-custom {
            background-color: var(--primary-guindo);
            color: var(--text-light);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-custom:hover {
            background-color: var(--dark-guindo);
            color: var(--text-light);
            transform: translateY(-2px);
        }
        
        .btn-outline-custom {
            background-color: transparent;
            color: var(--primary-guindo);
            border: 2px solid var(--primary-guindo);
            padding: 8px 18px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            background-color: var(--primary-guindo);
            color: var(--text-light);
        }
        
        .table-custom {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .table-custom thead {
            background-color: var(--primary-guindo);
            color: var(--text-light);
        }
        
        .table-custom th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }
        
        .table-custom td {
            padding: 15px;
            vertical-align: middle;
            border-color: var(--gray-medium);
        }
        
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .form-control, .form-select {
            border: 2px solid var(--gray-medium);
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-guindo);
            box-shadow: 0 0 0 0.2rem rgba(128, 0, 32, 0.15);
        }
        
        .stats-card {
            text-align: center;
            padding: 20px;
        }
        
        .stats-icon {
            font-size: 2.5rem;
            color: var(--primary-guindo);
            margin-bottom: 15px;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-guindo);
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: var(--text-dark);
            font-weight: 600;
        }
        
        .page-section {
            display: none;
        }
        
        .page-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        
        .calendar-day {
            border: 1px solid var(--gray-medium);
            padding: 10px;
            height: 120px;
            overflow-y: auto;
        }
        
        .calendar-day.today {
            background-color: var(--lighter-guindo);
        }
        
        .calendar-event {
            background-color: var(--primary-guindo);
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
            }
            
            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 10px;
            }
            
            .nav-link {
                border-left: none;
                border-bottom: 3px solid transparent;
                white-space: nowrap;
            }
            
            .nav-link:hover, .nav-link.active {
                border-left-color: transparent;
                border-bottom-color: var(--accent-gold);
            }
        }
    </style>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-graduation-cap me-2"></i>Panel del Tutor</h3>
            </div>
            <div class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-page="dashboard">
                            <i class="fas fa-tachometer-alt"></i> Mi Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="mistutorias">
                            <i class="fas fa-chalkboard-teacher"></i> Mis Tutorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="asistencia">
                            <i class="fas fa-clipboard-check"></i> Registrar Asistencia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="horario">
                            <i class="fas fa-calendar-alt"></i> Mi Horario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="estudiantes">
                            <i class="fas fa-user-graduate"></i> Mis Estudiantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="recursos">
                            <i class="fas fa-file-alt"></i> Recursos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <div>
                    <h4 class="mb-0" id="current-page-title">Mi Dashboard</h4>
                </div>
                <div class="user-info">
                    <div class="user-avatar">CR</div>
                    <div>
                        <div class="fw-bold">Dr. Carlos Rodríguez</div>
                        <div class="small text-muted">Tutor - Matemáticas</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-custom ms-3">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                <!-- Dashboard Page -->
                <div id="dashboard" class="page-section active">
                    <div class="page-header">
                        <h1 class="page-title">Mi Dashboard</h1>
                        <p class="text-muted">Resumen de mis actividades como tutor</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="stats-number">{{ $tutorias_programadas->count() }}</div>
                                <div class="stats-label">Tutorías Programadas</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="stats-number">{{ $estudiantes->count() }}</div>
                                <div class="stats-label">Estudiantes Asignados</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="stats-number">88%</div>
                                <div class="stats-label">Asistencia Promedio</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="stats-number">4.7</div>
                                <div class="stats-label">Calificación</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-calendar-alt me-2"></i>Próximas Tutorías
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tutoría</th>
                                                    <th>Fecha y Hora</th>
                                                    <th>Estudiante</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tutorias_programadas->take(3) as $tutoria)
                                                @php
                                                    $estudiante_nombre = $estudiantes->firstWhere('id', $tutoria->id_estudiante)->name ?? 'Estudiante no encontrado';
                                                    $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                                    $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                                                @endphp
                                                <tr>
                                                    <td>{{ $tutoria->tema }}</td>
                                                    <td>{{ $fecha_formateada }} {{ $hora_inicio }}</td>
                                                    <td>{{ $estudiante_nombre }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom me-1">Preparar</button>
                                                        <button class="btn btn-sm btn-custom">Iniciar</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                                @if($tutorias_programadas->count() == 0)
                                                <tr>
                                                    <td colspan="4" class="text-center">No hay tutorías programadas</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-tasks me-2"></i>Tareas Pendientes
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox" id="tarea1">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Preparar material para tutoría de Matemáticas Avanzadas</p>
                                            <small class="text-muted">Para hoy</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox" id="tarea2">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Revisar ejercicios de Álgebra Lineal</p>
                                            <small class="text-muted">Para mañana</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox" id="tarea3" checked>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1 text-decoration-line-through">Enviar recordatorio a estudiantes</p>
                                            <small class="text-muted">Completado</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-bell me-2"></i>Notificaciones
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Nuevo estudiante asignado: Ana Martínez</p>
                                            <small class="text-muted">Hace 2 horas</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Recordatorio: Tutoría de Matemáticas hoy a las 10:00 AM</p>
                                            <small class="text-muted">Hace 5 horas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mis Tutorías Page -->
                <div id="mistutorias" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Mis Tutorías</h1>
                        <p class="text-muted">Gestionar mis sesiones de tutoría</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"></i>Mis Tutorías Programadas</span>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#solicitarTutoriaModal">
                                <i class="fas fa-plus me-1"></i> Programar Nueva Tutoría
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>Tema</th>
                                            <th>Estudiante</th>
                                            <th>Fecha y Hora</th>
                                            <th>Duración</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tutorias_programadas as $tutoria)
                                        @php
                                            $estudiante_nombre = $estudiantes->firstWhere('id', $tutoria->id_estudiante)->name ?? 'Estudiante no encontrado';
                                            $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                            $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                                            $hora_fin = \Carbon\Carbon::parse($tutoria->hora_fin)->format('H:i');
                                            $inicio = \Carbon\Carbon::parse($tutoria->hora_inicio);
                                            $fin = \Carbon\Carbon::parse($tutoria->hora_fin);
                                            $duracion = $inicio->diff($fin);
                                            $duracion_texto = $duracion->h . 'h ' . $duracion->i . 'm';
                                        @endphp
                                        <tr>
                                            <td>{{ $tutoria->tema }}</td>
                                            <td>{{ $estudiante_nombre }}</td>
                                            <td>{{ $fecha_formateada }} {{ $hora_inicio }}</td>
                                            <td>{{ $duracion_texto }}</td>
                                            <td class='user-actions'>
                                                <button class='btn btn-sm btn-outline-custom me-1' data-bs-toggle='modal' data-bs-target='#editarTutoriaModal' 
                                                        data-id='{{ $tutoria->id }}' 
                                                        data-tema='{{ $tutoria->tema }}' 
                                                        data-id_estudiante='{{ $tutoria->id_estudiante }}' 
                                                        data-fecha='{{ $tutoria->fecha }}' 
                                                        data-hora_inicio='{{ $tutoria->hora_inicio }}' 
                                                        data-hora_fin='{{ $tutoria->hora_fin }}' 
                                                        data-observaciones='{{ $tutoria->observaciones }}'>
                                                    <i class='fas fa-edit'></i> Editar
                                                </button>
                                                
                                                <form method='POST' action='{{ route("tutorias.destroy", $tutoria->id) }}' style='display:inline;' onsubmit='return confirm("¿Está seguro de que desea cancelar esta tutoría?");'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='submit' class='btn btn-sm btn-outline-custom'>
                                                        <i class='fas fa-times'></i> Cancelar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        @if($tutorias_programadas->count() == 0)
                                        <tr>
                                            <td colspan='5' class='text-center'>No hay tutorías programadas</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <i class="fas fa-history me-2"></i>Tutorías Pasadas
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tema</th>
                                            <th>Estudiante</th>
                                            <th>Fecha</th>
                                            <th>Horario</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tutorias_pasadas as $tutoria)
                                        @php
                                            $estudiante_nombre = $estudiantes->firstWhere('id', $tutoria->id_estudiante)->name ?? 'Estudiante no encontrado';
                                            $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                            $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                                            $hora_fin = \Carbon\Carbon::parse($tutoria->hora_fin)->format('H:i');
                                        @endphp
                                        <tr>
                                            <td>{{ $tutoria->tema }}</td>
                                            <td>{{ $estudiante_nombre }}</td>
                                            <td>{{ $fecha_formateada }}</td>
                                            <td>{{ $hora_inicio }} - {{ $hora_fin }}</td>
                                            <td>{{ $tutoria->observaciones ? substr($tutoria->observaciones, 0, 50) . '...' : 'Sin observaciones' }}</td>
                                        </tr>
                                        @endforeach
                                        
                                        @if($tutorias_pasadas->count() == 0)
                                        <tr>
                                            <td colspan='5' class='text-center'>No hay tutorías pasadas</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Asistencia Page -->
                <div id="asistencia" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Registrar Asistencia</h1>
                        <p class="text-muted">Controlar la asistencia de los estudiantes</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-clipboard-list me-2"></i>Registro de Asistencia
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('asistencia.registrar') }}" id="formAsistencia">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="selectTutoria" class="form-label">Seleccionar Tutoría</label>
                                            <select class="form-select" id="selectTutoria" name="tutoria_id" required>
                                                <option value="">Seleccione una tutoría...</option>
                                                @foreach($tutorias_programadas as $tutoria)
                                                    @php
                                                        $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                                        $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                                                    @endphp
                                                    <option value="{{ $tutoria->id }}">
                                                        {{ $tutoria->tema }} - {{ $fecha_formateada }} {{ $hora_inicio }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div id="tablaAsistencia" style="display: none;">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Estudiante</th>
                                                            <th>Asistencia</th>
                                                            <th>Observaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyEstudiantes">
                                                        <!-- Los estudiantes se cargarán aquí dinámicamente -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-custom">
                                                    <i class="fas fa-save me-1"></i> Guardar Asistencia
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-2"></i>Resumen de Asistencia
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <h3 class="text-primary" id="porcentajeAsistencia">0%</h3>
                                        <p class="text-muted">Asistencia General</p>
                                    </div>
                                    <div class="d-flex justify-content-around mb-3">
                                        <div>
                                            <h5 class="text-success" id="totalPresentes">0</h5>
                                            <small>Presentes</small>
                                        </div>
                                        <div>
                                            <h5 class="text-danger" id="totalAusentes">0</h5>
                                            <small>Ausentes</small>
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-success" id="barraProgreso" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="infoTutoria">Seleccione una tutoría</small>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-history me-2"></i>Historial Reciente
                                </div>
                                <div class="card-body" id="historialAsistencia">
                                    <div class="text-center text-muted">
                                        <small>No hay historial reciente</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Horario Page -->
                <div id="horario" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Mi Horario</h1>
                        <p class="text-muted">Gestionar mi disponibilidad y horario de tutorías</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-calendar-alt me-2"></i>Calendario de Tutorías
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-4">
                                        <h4 id="mesActual">Noviembre 2025</h4>
                                        <div>
                                            <button class="btn btn-outline-custom me-2" id="btnMesAnterior">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <button class="btn btn-outline-custom" id="btnMesSiguiente">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center" id="calendario">
                                            <thead>
                                                <tr>
                                                    <th>Lun</th>
                                                    <th>Mar</th>
                                                    <th>Mié</th>
                                                    <th>Jue</th>
                                                    <th>Vie</th>
                                                    <th>Sáb</th>
                                                    <th>Dom</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cuerpoCalendario">
                                                <!-- El calendario se generará dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-clock me-2"></i>Mi Disponibilidad
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('horario.update') }}" id="formHorario">
                                        @csrf
                                        <div class="mb-3">
                                            <h5>Horario Semanal</h5>
                                            <div class="list-group" id="listaHorarios">
                                                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $dia)
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <strong>{{ $dia }}</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="time" class="form-control form-control-sm" 
                                                                   name="dias[{{ $loop->index }}][hora_inicio]" 
                                                                   value="09:00">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="time" class="form-control form-control-sm" 
                                                                   name="dias[{{ $loop->index }}][hora_fin]" 
                                                                   value="13:00">
                                                        </div>
                                                        <input type="hidden" name="dias[{{ $loop->index }}][dia]" value="{{ $dia }}">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-custom">
                                                <i class="fas fa-save me-1"></i> Guardar Horario
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-list me-2"></i>Próximas Tutorías
                                </div>
                                <div class="card-body" id="proximasTutorias">
                                    @foreach($tutorias_programadas->take(3) as $tutoria)
                                    @php
                                        $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m');
                                        $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                                    @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $tutoria->tema }}</span>
                                            <small class="text-muted">{{ $hora_inicio }}</small>
                                        </div>
                                        <small class="text-muted">{{ $fecha_formateada }}</small>
                                    </div>
                                    @endforeach
                                    
                                    @if($tutorias_programadas->count() == 0)
                                    <div class="text-center text-muted">
                                        <small>No hay tutorías programadas</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mis Estudiantes Page -->
                <div id="estudiantes" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Mis Estudiantes</h1>
                        <p class="text-muted">Gestionar la información de mis estudiantes</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-user-graduate me-2"></i>Lista de Estudiantes Asignados
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Asistencia</th>
                                            <th>Última Tutoría</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($estudiantes as $estudiante)
                                        @php
                                            $porcentajeAsistencia = rand(70, 100);
                                            $ultimaTutoria = $tutorias_pasadas->where('id_estudiante', $estudiante->id)->first();
                                            $fechaUltima = $ultimaTutoria ? \Carbon\Carbon::parse($ultimaTutoria->fecha)->format('d/m/Y') : 'N/A';
                                        @endphp
                                        <tr>
                                            <td>{{ $estudiante->name }}</td>
                                            <td>{{ $estudiante->email }}</td>
                                            <td>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $porcentajeAsistencia }}%"></div>
                                                </div>
                                                <small>{{ $porcentajeAsistencia }}%</small>
                                            </td>
                                            <td>{{ $fechaUltima }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1 btn-contactar" data-email="{{ $estudiante->email }}">
                                                    <i class="fas fa-envelope me-1"></i> Contactar
                                                </button>
                                                <button class="btn btn-sm btn-outline-custom btn-progreso" data-estudiante="{{ $estudiante->id }}">
                                                    <i class="fas fa-chart-line me-1"></i> Progreso
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        @if($estudiantes->count() == 0)
                                        <tr>
                                            <td colspan="5" class="text-center">No hay estudiantes asignados</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-2"></i>Rendimiento por Materia
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Matemáticas Avanzadas</span>
                                            <span class="badge badge-custom badge-success">8.5/10</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: 85%"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Cálculo Diferencial</span>
                                            <span class="badge badge-custom badge-warning">7.2/10</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: 72%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <span>Álgebra Lineal</span>
                                            <span class="badge badge-custom badge-success">8.8/10</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: 88%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-comments me-2"></i>Comentarios Recientes
                                </div>
                                <div class="card-body" id="comentariosEstudiantes">
                                    @foreach($estudiantes->take(3) as $estudiante)
                                    <div class="mb-3">
                                        <p class="mb-1">"Excelente explicación sobre los temas tratados"</p>
                                        <small class="text-muted">- {{ $estudiante->name }}, {{ \Carbon\Carbon::now()->subDays(rand(1, 10))->format('d/m/Y') }}</small>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recursos Page -->
                <div id="recursos" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Recursos</h1>
                        <p class="text-muted">Gestionar materiales y recursos para las tutorías</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-folder me-2"></i>Mis Recursos</span>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#subirRecursoModal">
                                <i class="fas fa-upload me-1"></i> Subir Recurso
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row" id="listaRecursos">
                                <!-- Los recursos se cargarán dinámicamente -->
                                <div class="col-12 text-center">
                                    <p class="text-muted">No hay recursos subidos aún</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <i class="fas fa-link me-2"></i>Enlaces Útiles
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="https://www.khanacademy.org/math" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Khan Academy - Matemáticas
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="https://www.wolframalpha.com/" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Wolfram Alpha - Calculadora
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="https://www.geogebra.org/" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    GeoGebra - Geometría Interactiva
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Programar Tutoría -->
    <div class="modal fade" id="solicitarTutoriaModal" tabindex="-1" aria-labelledby="solicitarTutoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="solicitarTutoriaModalLabel">Programar Nueva Tutoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('tutorias.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tema" class="form-label">Tema/Materia</label>
                            <input type="text" class="form-control" id="tema" name="tema" placeholder="Ej: Matemáticas Avanzadas, Cálculo Diferencial, etc." required>
                        </div>
                        <div class="mb-3">
                            <label for="id_estudiante" class="form-label">Estudiante</label>
                            <select class="form-select" id="id_estudiante" name="id_estudiante" required>
                                <option value="">Seleccionar estudiante...</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}">{{ $estudiante->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hora_fin" class="form-label">Hora de Fin</label>
                                    <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Descripción/Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Describa los temas a tratar, materiales necesarios, observaciones..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Programar Tutoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Tutoría -->
    <div class="modal fade" id="editarTutoriaModal" tabindex="-1" aria-labelledby="editarTutoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTutoriaModalLabel">Editar Tutoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="formEditarTutoria">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_tutoria_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_tema" class="form-label">Tema de la Tutoría</label>
                            <input type="text" class="form-control" id="edit_tema" name="tema" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_estudiante" class="form-label">Estudiante</label>
                            <select class="form-select" id="edit_id_estudiante" name="id_estudiante" required>
                                <option value="">Seleccionar estudiante...</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}">{{ $estudiante->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="edit_fecha" name="fecha" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_hora_inicio" class="form-label">Hora de Inicio</label>
                                    <input type="time" class="form-control" id="edit_hora_inicio" name="hora_inicio" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_hora_fin" class="form-label">Hora de Fin</label>
                                    <input type="time" class="form-control" id="edit_hora_fin" name="hora_fin" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="edit_observaciones" name="observaciones" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Actualizar Tutoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Subir Recurso -->
    <div class="modal fade" id="subirRecursoModal" tabindex="-1" aria-labelledby="subirRecursoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subirRecursoModalLabel">Subir Nuevo Recurso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSubirRecurso">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombreRecurso" class="form-label">Nombre del Recurso</label>
                            <input type="text" class="form-control" id="nombreRecurso" placeholder="Ej: Guía de Ejercicios" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipoRecurso" class="form-label">Tipo de Recurso</label>
                            <select class="form-select" id="tipoRecurso" required>
                                <option value="documento">Documento</option>
                                <option value="presentacion">Presentación</option>
                                <option value="video">Video</option>
                                <option value="enlace">Enlace</option>
                            </select>
                        </div>
                        <div class="mb-3" id="campoArchivo">
                            <label for="archivoRecurso" class="form-label">Archivo</label>
                            <input class="form-control" type="file" id="archivoRecurso">
                        </div>
                        <div class="mb-3" id="campoEnlace" style="display: none;">
                            <label for="enlaceRecurso" class="form-label">Enlace</label>
                            <input type="url" class="form-control" id="enlaceRecurso" placeholder="https://...">
                        </div>
                        <div class="mb-3">
                            <label for="descripcionRecurso" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionRecurso" rows="3" placeholder="Descripción del recurso..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Subir Recurso</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navegación entre páginas
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remover clase active de todos los enlaces
                document.querySelectorAll('.nav-link').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Agregar clase active al enlace clickeado
                this.classList.add('active');
                
                // Ocultar todas las páginas
                document.querySelectorAll('.page-section').forEach(page => {
                    page.classList.remove('active');
                });
                
                // Mostrar la página correspondiente
                const pageId = this.getAttribute('data-page');
                document.getElementById(pageId).classList.add('active');
                
                // Actualizar título de la página
                const pageTitle = this.textContent.trim();
                document.getElementById('current-page-title').textContent = pageTitle;
            });
        });

        // Configurar modal de editar tutoría
        const editarTutoriaModal = document.getElementById('editarTutoriaModal');
        if (editarTutoriaModal) {
            editarTutoriaModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const tutoriaId = button.getAttribute('data-id');
                
                document.getElementById('edit_tutoria_id').value = tutoriaId;
                document.getElementById('edit_tema').value = button.getAttribute('data-tema');
                document.getElementById('edit_id_estudiante').value = button.getAttribute('data-id_estudiante');
                document.getElementById('edit_fecha').value = button.getAttribute('data-fecha');
                document.getElementById('edit_hora_inicio').value = button.getAttribute('data-hora_inicio');
                document.getElementById('edit_hora_fin').value = button.getAttribute('data-hora_fin');
                document.getElementById('edit_observaciones').value = button.getAttribute('data-observaciones');
                
                // Actualizar la acción del formulario
                document.getElementById('formEditarTutoria').action = `/tutorias/${tutoriaId}`;
            });
        }

        // Funcionalidad de tareas pendientes
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskText = this.closest('.d-flex').querySelector('p');
                if (this.checked) {
                    taskText.classList.add('text-decoration-line-through');
                } else {
                    taskText.classList.remove('text-decoration-line-through');
                }
            });
        });

        // Funcionalidad de asistencia
        const selectTutoria = document.getElementById('selectTutoria');
        const tablaAsistencia = document.getElementById('tablaAsistencia');
        
        if (selectTutoria) {
            selectTutoria.addEventListener('change', function() {
                if (this.value) {
                    // Simular carga de estudiantes para la tutoría seleccionada
                    const estudiantes = @json($estudiantes);
                    const tbody = document.getElementById('tbodyEstudiantes');
                    tbody.innerHTML = '';
                    
                    estudiantes.forEach(estudiante => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${estudiante.name}</td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" 
                                           name="asistencias[${estudiante.id}][asistio]" 
                                           value="1" id="presente${estudiante.id}" checked>
                                    <label class="form-check-label" for="presente${estudiante.id}">Presente</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" 
                                           name="asistencias[${estudiante.id}][asistio]" 
                                           value="0" id="ausente${estudiante.id}">
                                    <label class="form-check-label" for="ausente${estudiante.id}">Ausente</label>
                                </div>
                                <input type="hidden" name="asistencias[${estudiante.id}][estudiante_id]" value="${estudiante.id}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" 
                                       name="asistencias[${estudiante.id}][observaciones]" 
                                       placeholder="Observaciones...">
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                    
                    tablaAsistencia.style.display = 'block';
                    
                    // Actualizar resumen
                    document.getElementById('porcentajeAsistencia').textContent = '88%';
                    document.getElementById('totalPresentes').textContent = estudiantes.length - 1;
                    document.getElementById('totalAusentes').textContent = '1';
                    document.getElementById('barraProgreso').style.width = '88%';
                    document.getElementById('infoTutoria').textContent = 'Tutoría seleccionada';
                    
                    // Simular historial
                    const historial = document.getElementById('historialAsistencia');
                    historial.innerHTML = `
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Matemáticas Básicas</span>
                                <span class="badge badge-custom badge-success">80%</span>
                            </div>
                            <small class="text-muted">10 Nov 2025</small>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Introducción al Cálculo</span>
                                <span class="badge badge-custom badge-warning">83%</span>
                            </div>
                            <small class="text-muted">8 Nov 2025</small>
                        </div>
                    `;
                } else {
                    tablaAsistencia.style.display = 'none';
                }
            });
        }

        // Funcionalidad del calendario
        let fechaActual = new Date();
        
        function generarCalendario() {
            const año = fechaActual.getFullYear();
            const mes = fechaActual.getMonth();
            const primerDia = new Date(año, mes, 1);
            const ultimoDia = new Date(año, mes + 1, 0);
            const diasEnMes = ultimoDia.getDate();
            const primerDiaSemana = primerDia.getDay();
            
            const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                                 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            
            document.getElementById('mesActual').textContent = `${nombresMeses[mes]} ${año}`;
            
            const cuerpo = document.getElementById('cuerpoCalendario');
            cuerpo.innerHTML = '';
            
            let fecha = 1;
            for (let i = 0; i < 6; i++) {
                const fila = document.createElement('tr');
                
                for (let j = 0; j < 7; j++) {
                    const celda = document.createElement('td');
                    celda.className = 'calendar-day';
                    
                    if (i === 0 && j < primerDiaSemana) {
                        const diaAnterior = new Date(año, mes, 0).getDate() - (primerDiaSemana - j - 1);
                        celda.innerHTML = `${diaAnterior}<br><small class="text-muted">${mes === 0 ? 'Dic' : nombresMeses[mes-1].substring(0,3)}</small>`;
                        celda.classList.add('text-muted');
                    } else if (fecha > diasEnMes) {
                        const diaSiguiente = fecha - diasEnMes;
                        celda.innerHTML = `${diaSiguiente}<br><small class="text-muted">${mes === 11 ? 'Ene' : nombresMeses[mes+1].substring(0,3)}</small>`;
                        celda.classList.add('text-muted');
                        fecha++;
                    } else {
                        const hoy = new Date();
                        if (fecha === hoy.getDate() && mes === hoy.getMonth() && año === hoy.getFullYear()) {
                            celda.classList.add('today');
                        }
                        
                        // Simular eventos de tutorías
                        if (fecha % 5 === 0 || fecha % 7 === 0) {
                            celda.innerHTML = `${fecha}<br><div class="calendar-event">Tutoría 10:00</div>`;
                        } else {
                            celda.innerHTML = fecha;
                        }
                        fecha++;
                    }
                    
                    fila.appendChild(celda);
                }
                
                cuerpo.appendChild(fila);
                
                if (fecha > diasEnMes) {
                    break;
                }
            }
        }
        
        document.getElementById('btnMesAnterior').addEventListener('click', function() {
            fechaActual.setMonth(fechaActual.getMonth() - 1);
            generarCalendario();
        });
        
        document.getElementById('btnMesSiguiente').addEventListener('click', function() {
            fechaActual.setMonth(fechaActual.getMonth() + 1);
            generarCalendario();
        });
        
        // Inicializar calendario
        generarCalendario();

        // Funcionalidad de recursos
        const tipoRecurso = document.getElementById('tipoRecurso');
        const campoArchivo = document.getElementById('campoArchivo');
        const campoEnlace = document.getElementById('campoEnlace');
        
        tipoRecurso.addEventListener('change', function() {
            if (this.value === 'enlace') {
                campoArchivo.style.display = 'none';
                campoEnlace.style.display = 'block';
            } else {
                campoArchivo.style.display = 'block';
                campoEnlace.style.display = 'none';
            }
        });
        
        document.getElementById('formSubirRecurso').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombre = document.getElementById('nombreRecurso').value;
            const tipo = document.getElementById('tipoRecurso').value;
            const descripcion = document.getElementById('descripcionRecurso').value;
            
            // Simular subida de recurso
            const recursos = [
                {
                    nombre: nombre,
                    tipo: tipo,
                    descripcion: descripcion,
                    fecha: new Date().toLocaleDateString(),
                    icono: tipo === 'documento' ? 'file-pdf' : 
                           tipo === 'presentacion' ? 'file-powerpoint' : 
                           tipo === 'video' ? 'file-video' : 'link',
                    color: tipo === 'documento' ? 'danger' : 
                          tipo === 'presentacion' ? 'warning' : 
                          tipo === 'video' ? 'primary' : 'success'
                }
            ];
            
            actualizarListaRecursos(recursos);
            
            // Cerrar modal y resetear formulario
            const modal = bootstrap.Modal.getInstance(document.getElementById('subirRecursoModal'));
            modal.hide();
            this.reset();
            
            alert('Recurso subido correctamente');
        });
        
        function actualizarListaRecursos(recursos) {
            const lista = document.getElementById('listaRecursos');
            lista.innerHTML = '';
            
            recursos.forEach(recurso => {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-4';
                col.innerHTML = `
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-${recurso.icono} fa-3x text-${recurso.color} mb-3"></i>
                            <h5>${recurso.nombre}</h5>
                            <p class="text-muted">${recurso.tipo.charAt(0).toUpperCase() + recurso.tipo.slice(1)}</p>
                            <p class="small">${recurso.descripcion}</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-custom btn-sm">Descargar</button>
                                <button class="btn btn-outline-custom btn-sm">Compartir</button>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            Subido: ${recurso.fecha}
                        </div>
                    </div>
                `;
                lista.appendChild(col);
            });
        }

        // Funcionalidad de estudiantes
        document.querySelectorAll('.btn-contactar').forEach(btn => {
            btn.addEventListener('click', function() {
                const email = this.getAttribute('data-email');
                alert(`Redirigiendo a cliente de correo para contactar a: ${email}`);
            });
        });
        
        document.querySelectorAll('.btn-progreso').forEach(btn => {
            btn.addEventListener('click', function() {
                const estudianteId = this.getAttribute('data-estudiante');
                alert(`Mostrando progreso del estudiante ID: ${estudianteId}`);
            });
        });

        // Ocultar mensajes de alerta después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Simular envío de formularios
        document.getElementById('formAsistencia')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Asistencia registrada correctamente');
            // Aquí iría la lógica real de envío del formulario
        });
        
        document.getElementById('formHorario')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Horario actualizado correctamente');
            // Aquí iría la lógica real de envío del formulario
        });
    </script>
</body>
</html>