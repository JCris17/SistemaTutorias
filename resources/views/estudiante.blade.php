@php
    
    $tutorias_inscritas = $tutorias_inscritas ?? collect([]);
    $historial_tutorias = $historial_tutorias ?? collect([]);
    $tutorias_disponibles = $tutorias_disponibles ?? collect([]);
    $tutorias_invitadas = $tutorias_invitadas ?? collect([]);
    $materias = $materias ?? collect([]);
    $tutores = $tutores ?? collect([]);
    
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Tutorías - Panel del Estudiante</title>
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
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
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
        
        .badge-primary {
            background-color: #cce7ff;
            color: #004085;
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
        
        .progress-sm {
            height: 8px;
        }
        
        .invitation-card {
            border-left: 4px solid var(--accent-gold);
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
    @php
        // Inicializar todas las variables para evitar errores
        $tutorias_inscritas = $tutorias_inscritas ?? collect([]);
        $historial_tutorias = $historial_tutorias ?? collect([]);
        $tutorias_disponibles = $tutorias_disponibles ?? collect([]);
        $tutorias_invitadas = $tutorias_invitadas ?? collect([]);
        $materias = $materias ?? collect([]);
        $tutores = $tutores ?? collect([]);
        $total_tutorias_completadas = $total_tutorias_completadas ?? 0;
        $asistencias_ausente = $asistencias_ausente ?? 0;
        $rendimiento_materias = $rendimiento_materias ?? [];
        $evaluaciones_lista = $evaluaciones_lista ?? collect([]);
        $logros = $logros ?? [];
        $materiales_por_materia = $materiales_por_materia ?? collect([]);
        $materiales_recientes = $materiales_recientes ?? collect([]);
        $enlaces_utiles = $enlaces_utiles ?? [];
        $solicitudes_recientes = $solicitudes_recientes ?? collect([]);
        $evaluaciones = $evaluaciones ?? collect([]);
    @endphp

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
                <h3><i class="fas fa-graduation-cap me-2"></i>Panel del Estudiante</h3>
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
                        <a class="nav-link" href="#" data-page="inscribirse">
                            <i class="fas fa-calendar-plus"></i> Inscribirse en Tutorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="progreso">
                            <i class="fas fa-chart-line"></i> Mi Progreso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="recursos">
                            <i class="fas fa-file-alt"></i> Recursos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="solicitudes">
                            <i class="fas fa-question-circle"></i> Solicitar Ayuda
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
                    <div class="user-avatar">{{ substr($estudiante->name, 0, 2) }}</div>
                    <div>
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <div class="small text-muted">Estudiante - {{ Auth::user()->carrera ?? 'Ing. Sistemas' }}</div>
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
                        <p class="text-muted">Resumen de mis actividades académicas</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="stats-number">{{ $tutorias_inscritas_count ?? 0 }}</div>
                                <div class="stats-label">Tutorías Esta Semana</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="stats-number">{{ $porcentaje_asistencia ?? 0 }}%</div>
                                <div class="stats-label">Asistencia</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="stats-number">{{ $promedio_general ?? 0 }}</div>
                                <div class="stats-label">Promedio</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div class="stats-number">{{ $tareas_pendientes_count ?? 0 }}</div>
                                <div class="stats-label">Tareas Pendientes</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-calendar-alt me-2"></i>Mis Próximas Tutorías
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tutoría</th>
                                                    <th>Tutor</th>
                                                    <th>Fecha y Hora</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($proximas_tutorias ?? [] as $tutoria)
                                                @php
                                                    $tutor = App\Models\User::find($tutoria->id_tutor);
                                                    $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                                    $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                                                @endphp
                                                <tr>
                                                    <td>{{ $tutoria->tema }}</td>
                                                    <td>{{ $tutor->name ?? 'Tutor no asignado' }}</td>
                                                    <td>{{ $fecha_formateada }}, {{ $hora_inicio }}</td>
                                                    <td>
                                                        <span class="badge badge-custom 
                                                            {{ $tutoria->estado == 'activa' ? 'badge-success' : 
                                                               ($tutoria->estado == 'pendiente' ? 'badge-warning' : 'badge-danger') }}">
                                                            {{ ucfirst($tutoria->estado) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom btn-ver-detalles" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#detallesTutoriaModal"
                                                                data-tema="{{ $tutoria->tema }}"
                                                                data-tutor="{{ $tutor->name ?? 'Tutor no asignado' }}"
                                                                data-fecha="{{ $fecha_formateada }}"
                                                                data-hora="{{ $hora_inicio }}"
                                                                data-modalidad="{{ $tutoria->modalidad ?? 'No especificado' }}"
                                                                data-ubicacion="{{ $tutoria->ubicacion ?? 'No especificado' }}"
                                                                data-duracion="{{ $tutoria->duracion ?? 'No especificado' }}"
                                                                data-observaciones="{{ $tutoria->observaciones ?? 'Sin observaciones' }}">
                                                            Ver Detalles
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No tienes tutorías programadas</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-bell me-2"></i>Notificaciones Recientes
                                </div>
                                <div class="card-body">
                                    @forelse($notificaciones ?? [] as $notificacion)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-{{ $notificacion->tipo == 'info' ? 'info-circle text-primary' : 
                                                              ($notificacion->tipo == 'exito' ? 'check-circle text-success' : 'exclamation-triangle text-warning') }}"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">{{ $notificacion->mensaje }}</p>
                                            <small class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center text-muted">
                                        <p>No hay notificaciones recientes</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-tasks me-2"></i>Mis Tareas Pendientes
                                </div>
                                <div class="card-body">
                                    @forelse($tareas_pendientes ?? [] as $tarea)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox" 
                                                   data-tarea-id="{{ $tarea->id }}"
                                                   {{ $tarea->completada ? 'checked' : '' }}>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1 {{ $tarea->completada ? 'text-decoration-line-through' : '' }}">{{ $tarea->descripcion }}</p>
                                            <small class="text-muted">Para {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center text-muted">
                                        <p>No hay tareas pendientes</p>
                                    </div>
                                    @endforelse
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
        <div class="card-header">
            <i class="fas fa-list me-2"></i>Tutorías Inscritas
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-custom">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tutor</th>
                            <th>Fecha y Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse($tutorias_inscritas as $tutoria)
                        @php
                            $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                            $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                        @endphp
                        <tr>
                            <td>{{ $tutoria->tema }}</td>
                            <td>{{ $tutoria->tutor_name ?? 'Tutor no asignado' }}</td>
                            <td>{{ $fecha_formateada }} {{ $hora_inicio }}</td>
                            <td>
                                <span class="badge badge-custom 
                                    {{ $tutoria->estado_inscripcion == 'confirmada' ? 'badge-success' : 
                                    ($tutoria->estado_inscripcion == 'pendiente' ? 'badge-warning' : 'badge-danger') }}">
                                    {{ ucfirst($tutoria->estado_inscripcion) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-custom me-1 btn-ver-detalles"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#detallesTutoriaModal"
                                        data-tema="{{ $tutoria->tema }}"
                                        data-tutor="{{ $tutoria->tutor_name ?? 'Tutor no asignado' }}"
                                        data-fecha="{{ $fecha_formateada }}"
                                        data-hora="{{ $hora_inicio }}"
                                        data-observaciones="{{ $tutoria->observaciones ?? 'Sin observaciones' }}">
                                    Ver Detalles
                                </button>
                                @if($tutoria->estado_inscripcion == 'confirmada' || $tutoria->estado_inscripcion == 'pendiente')
                                <form method="POST" action="{{ route('estudiante.tutorias.cancelar', $tutoria->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Estás seguro de que quieres cancelar esta tutoría?')">
                                        Cancelar
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No estás inscrito en ninguna tutoría</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <i class="fas fa-history me-2"></i>Historial de Tutorías
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tutor</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historial_tutorias as $tutoria)
                        @php
                            $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                        @endphp
                        <tr>
                            <td>{{ $tutoria->tema }}</td>
                            <td>{{ $tutoria->tutor_name ?? 'Tutor no asignado' }}</td>
                            <td>{{ $fecha_formateada }}</td>
                            <td>
                                <span class="badge badge-custom badge-info">
                                    {{ ucfirst($tutoria->estado_inscripcion) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay historial de tutorías</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                
              <!-- Inscribirse Page -->
<div id="inscribirse" class="page-section">
    <div class="page-header">
        <h1 class="page-title">Inscribirse en Tutorías</h1>
        <p class="text-muted">Explora y inscríbete en tutorías disponibles</p>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-filter me-2"></i>Filtrar Tutorías
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('estudiante.inscribirse') }}" id="filtrosForm">
                        <div class="mb-3">
                            <label for="filtroMateria" class="form-label">Materia</label>
                            <select class="form-select" id="filtroMateria" name="materia">
                                <option value="">Todas las materias</option>
                                @foreach($materias as $materia)
                                <option value="{{ $materia }}" {{ request('materia') == $materia ? 'selected' : '' }}>{{ $materia }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="filtroTutor" class="form-label">Tutor</label>
                            <select class="form-select" id="filtroTutor" name="tutor">
                                <option value="">Todos los tutores</option>
                                @foreach($tutores as $tutor)
                                <option value="{{ $tutor->id }}" {{ request('tutor') == $tutor->id ? 'selected' : '' }}>{{ $tutor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Aplicar Filtros</button>
                        <a href="{{ route('estudiante.inscribirse') }}" class="btn btn-outline-custom w-100 mt-2">Limpiar Filtros</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list me-2"></i>Tutorías Disponibles
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($tutorias_disponibles as $tutoria)
                            @php
                                $tutor = App\Models\User::find($tutoria->id_tutor);
                                $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                            @endphp
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $tutoria->tema }}</h5>
                                        <p class="card-text">
                                            <strong>Tutor:</strong> {{ $tutor->name ?? 'Tutor no asignado' }}<br>
                                            <strong>Fecha:</strong> {{ $fecha_formateada }}<br>
                                            <strong>Hora:</strong> {{ $hora_inicio }}<br>
                                            <strong>Estado:</strong> 
                                            <span class="badge badge-custom 
                                                {{ $tutoria->estado == 'activa' ? 'badge-success' : 
                                                   ($tutoria->estado == 'pendiente' ? 'badge-warning' : 'badge-secondary') }}">
                                                {{ ucfirst($tutoria->estado) }}
                                            </span><br>
                                            @if($tutoria->observaciones)
                                                <strong>Observaciones:</strong> {{ $tutoria->observaciones }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        @if($tutoria->estado == 'activa' || $tutoria->estado == 'pendiente')
                                            <form method="POST" action="{{ route('estudiante.inscribir-tutoria', $tutoria->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-plus"></i> Inscribirse
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-ban"></i> No disponible
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-custom ms-1 btn-ver-detalles"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detallesTutoriaModal"
                                                data-tema="{{ $tutoria->tema }}"
                                                data-tutor="{{ $tutor->name ?? 'Tutor no asignado' }}"
                                                data-fecha="{{ $fecha_formateada }}"
                                                data-hora="{{ $hora_inicio }}"
                                                data-estado="{{ $tutoria->estado }}"
                                                data-observaciones="{{ $tutoria->observaciones ?? 'Sin observaciones' }}">
                                            Ver Detalles
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                    <p>No hay tutorías disponibles con los filtros seleccionados</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                <!-- Progreso Page -->
                <div id="progreso" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Mi Progreso Académico</h1>
                        <p class="text-muted">Seguimiento de mi rendimiento en tutorías</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-chart-line me-2"></i>Estadísticas de Rendimiento
                                </div>
                                <div class="card-body">
                                    <div class="row text-center mb-4">
                                        <div class="col-md-4">
                                            <h3 class="text-primary">{{ $porcentaje_asistencia ?? 0 }}%</h3>
                                            <p class="text-muted">Asistencia</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="text-success">{{ $promedio_general ?? 0 }}</h3>
                                            <p class="text-muted">Promedio General</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="text-info">{{ $total_tutorias_completadas ?? 0 }}</h3>
                                            <p class="text-muted">Tutorías Completadas</p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="mb-3">Rendimiento por Materia</h5>
                                    @foreach($rendimiento_materias as $materia => $datos)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>{{ $materia }}</span>
                                            <span>{{ $datos['promedio'] ?? 0 }}/10</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar 
                                                {{ ($datos['promedio'] ?? 0) >= 8 ? 'bg-success' : 
                                                   (($datos['promedio'] ?? 0) >= 6 ? 'bg-warning' : 'bg-danger') }}" 
                                                style="width: {{ ($datos['promedio'] ?? 0) * 10 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-calendar-check me-2"></i>Mi Asistencia
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <h3 class="text-primary">{{ $porcentaje_asistencia ?? 0 }}%</h3>
                                        <p class="text-muted">Asistencia General</p>
                                    </div>
                                    <div class="d-flex justify-content-around mb-3">
                                        <div>
                                            <h5 class="text-success">{{ $asistencias_presente ?? 0 }}</h5>
                                            <small>Presente</small>
                                        </div>
                                        <div>
                                            <h5 class="text-danger">{{ $asistencias_ausente ?? 0 }}</h5>
                                            <small>Ausente</small>
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-success" style="width: {{ $porcentaje_asistencia ?? 0 }}%"></div>
                                    </div>
                                    <small class="text-muted">Basado en {{ $total_asistencias ?? 0 }} tutorías</small>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-award me-2"></i>Logros
                                </div>
                                <div class="card-body">
                                    @foreach($logros as $logro)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-{{ $logro['icono'] ?? 'star' }} text-{{ $logro['color'] ?? 'warning' }}"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">{{ $logro['titulo'] ?? 'Logro' }}</p>
                                            <small class="text-muted">{{ $logro['descripcion'] ?? 'Descripción del logro' }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <i class="fas fa-history me-2"></i>Historial de Evaluaciones
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tutoría</th>
                                            <th>Tutor</th>
                                            <th>Fecha</th>
                                            <th>Calificación</th>
                                            <th>Comentarios</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($evaluaciones_lista as $evaluacion)
                                        @php
                                            $tutoria = App\Models\Tutoria::find($evaluacion->id_tutoria);
                                            $tutor = App\Models\User::find($tutoria->id_tutor ?? null);
                                            $fecha_formateada = \Carbon\Carbon::parse($evaluacion->created_at)->format('d/m/Y');
                                        @endphp
                                        <tr>
                                            <td>{{ $tutoria->tema ?? 'Tutoría no disponible' }}</td>
                                            <td>{{ $tutor->name ?? 'Tutor no asignado' }}</td>
                                            <td>{{ $fecha_formateada }}</td>
                                            <td>{{ $evaluacion->calificacion }}</td>
                                            <td>{{ $evaluacion->comentarios ?? 'Sin comentarios' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay evaluaciones registradas</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recursos Page -->
                <div id="recursos" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Recursos de Estudio</h1>
                        <p class="text-muted">Materiales y recursos para tus tutorías</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-folder me-2"></i>Materiales por Materia
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($materiales_por_materia as $materia => $materiales)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-{{ $materiales['icono'] ?? 'file' }} fa-3x text-{{ $materiales['color'] ?? 'secondary' }} mb-3"></i>
                                            <h5>{{ $materia }}</h5>
                                            <p class="text-muted">{{ $materiales['cantidad'] ?? 0 }} archivos disponibles</p>
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-outline-custom btn-sm btn-explorar-materia" data-materia="{{ $materia }}">
                                                    Explorar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <i class="fas fa-file-alt me-2"></i>Materiales Recientes
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Materia</th>
                                            <th>Tipo</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($materiales_recientes as $material)
                                        <tr>
                                            <td>{{ $material->nombre ?? 'Sin nombre' }}</td>
                                            <td>{{ $material->materia ?? 'Sin materia' }}</td>
                                            <td>{{ strtoupper($material->tipo ?? 'desconocido') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($material->created_at ?? now())->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ $material->url ?? '#' }}" class="btn btn-sm btn-outline-custom" target="_blank">
                                                    <i class="fas fa-download"></i> Descargar
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay materiales disponibles</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <i class="fas fa-link me-2"></i>Enlaces Útiles
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach($enlaces_utiles as $enlace)
                                <a href="{{ $enlace['url'] ?? '#' }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    {{ $enlace['nombre'] ?? 'Enlace' }}
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Solicitudes Page -->
                <div id="solicitudes" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Solicitar Ayuda</h1>
                        <p class="text-muted">Solicita tutorías personalizadas o ayuda adicional</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-question-circle me-2"></i>Nueva Solicitud
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('estudiante.solicitudes.crear') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="tipoSolicitud" class="form-label">Tipo de Solicitud</label>
                                            <select class="form-select" id="tipoSolicitud" name="tipo" required>
                                                <option value="">Seleccione el tipo de solicitud...</option>
                                                <option value="tutoria">Tutoría Personalizada</option>
                                                <option value="material">Material Adicional</option>
                                                <option value="duda">Consulta Específica</option>
                                                <option value="otro">Otro</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="materiaSolicitud" class="form-label">Materia</label>
                                            <select class="form-select" id="materiaSolicitud" name="materia" required>
                                                <option value="">Seleccione una materia...</option>
                                                @foreach($materias as $materia)
                                                <option value="{{ $materia }}">{{ $materia }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tutorPreferido" class="form-label">Tutor Preferido (Opcional)</label>
                                            <select class="form-select" id="tutorPreferido" name="id_tutor">
                                                <option value="">Sin preferencia</option>
                                                @foreach($tutores as $tutor)
                                                <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="descripcionSolicitud" class="form-label">Descripción</label>
                                            <textarea class="form-control" id="descripcionSolicitud" name="descripcion" rows="4" placeholder="Describe detalladamente tu solicitud..." required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="urgenciaSolicitud" class="form-label">Nivel de Urgencia</label>
                                            <select class="form-select" id="urgenciaSolicitud" name="urgencia" required>
                                                <option value="baja">Baja</option>
                                                <option value="media" selected>Media</option>
                                                <option value="alta">Alta</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-custom">Enviar Solicitud</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-history me-2"></i>Mis Solicitudes Recientes
                                </div>
                                <div class="card-body">
                                    @forelse($solicitudes_recientes as $solicitud)
                                    <div class="mb-3">
                                        <h6>{{ ucfirst($solicitud->tipo) }} - {{ $solicitud->materia }}</h6>
                                        <p class="mb-1 small">Solicitado: {{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}</p>
                                        <span class="badge badge-custom 
                                            {{ $solicitud->estado == 'aprobado' ? 'badge-success' : 
                                               ($solicitud->estado == 'en_proceso' ? 'badge-warning' : 'badge-info') }}">
                                            {{ ucfirst(str_replace('_', ' ', $solicitud->estado)) }}
                                        </span>
                                    </div>
                                    @empty
                                    <div class="text-center text-muted">
                                        <p>No hay solicitudes recientes</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-2"></i>Información de Contacto
                                </div>
                                <div class="card-body">
                                    <p>Si necesitas ayuda inmediata, puedes contactar a:</p>
                                    <ul class="list-unstyled">
                                        <li><strong>Coordinador de Tutorías:</strong></li>
                                        <li>Lic. Rodrigo Vera</li>
                                        <li>r.vera@univalle.edu</li>
                                        <li>Ext. 1234</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Detalles de Tutoría -->
    <div class="modal fade" id="detallesTutoriaModal" tabindex="-1" aria-labelledby="detallesTutoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesTutoriaModalLabel">Detalles de la Tutoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detalles-tutoria-body">
                    <!-- Los detalles se cargarán dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
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
        
        // Funcionalidad para ver detalles de tutoría
        document.querySelectorAll('.btn-ver-detalles').forEach(button => {
            button.addEventListener('click', function() {
                const tema = this.getAttribute('data-tema');
                const tutor = this.getAttribute('data-tutor');
                const fecha = this.getAttribute('data-fecha');
                const hora = this.getAttribute('data-hora');
                const modalidad = this.getAttribute('data-modalidad');
                const ubicacion = this.getAttribute('data-ubicacion');
                const duracion = this.getAttribute('data-duracion');
                const observaciones = this.getAttribute('data-observaciones');
                
                const detallesBody = document.getElementById('detalles-tutoria-body');
                detallesBody.innerHTML = `
                    <h5>${tema}</h5>
                    <p><strong>Tutor:</strong> ${tutor}</p>
                    <p><strong>Fecha y Hora:</strong> ${fecha}, ${hora}</p>
                    <p><strong>Modalidad:</strong> ${modalidad}</p>
                    <p><strong>Ubicación:</strong> ${ubicacion || 'Por definir'}</p>
                    <p><strong>Duración:</strong> ${duracion || 'Por definir'}</p>
                    ${observaciones ? `<p><strong>Observaciones:</strong> ${observaciones}</p>` : ''}
                `;
            });
        });
        
        // Funcionalidad para marcar tareas como completadas
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const tareaId = this.getAttribute('data-tarea-id');
                const taskText = this.closest('.d-flex').querySelector('p');
                
                if (this.checked) {
                    taskText.classList.add('text-decoration-line-through');
                    // Aquí iría una llamada AJAX para actualizar el estado en la base de datos
                    fetch(`/estudiante/tareas/${tareaId}/completar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ completada: true })
                    });
                } else {
                    taskText.classList.remove('text-decoration-line-through');
                    // Aquí iría una llamada AJAX para actualizar el estado en la base de datos
                    fetch(`/estudiante/tareas/${tareaId}/completar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ completada: false })
                    });
                }
            });
        });
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
        
        // Guardar la página activa en sessionStorage
        sessionStorage.setItem('activePage', pageId);
    });
});

// Al cargar la página, restaurar la sección activa si existe
document.addEventListener('DOMContentLoaded', function() {
    const activePage = sessionStorage.getItem('activePage');
    if (activePage && activePage !== 'dashboard') {
        // Remover active del dashboard
        document.querySelectorAll('.nav-link').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelectorAll('.page-section').forEach(page => {
            page.classList.remove('active');
        });
        
        // Activar la página guardada
        const targetLink = document.querySelector(`[data-page="${activePage}"]`);
        const targetPage = document.getElementById(activePage);
        
        if (targetLink && targetPage) {
            targetLink.classList.add('active');
            targetPage.classList.add('active');
            document.getElementById('current-page-title').textContent = targetLink.textContent.trim();
        }
    }
});

// Para el formulario de filtros, asegurar que se mantenga en la misma página
document.getElementById('filtrosForm')?.addEventListener('submit', function() {
    sessionStorage.setItem('activePage', 'inscribirse');
});

// Para los botones de inscripción, mantener la página activa
document.querySelectorAll('form[action*="inscribir-tutoria"]').forEach(form => {
    form.addEventListener('submit', function() {
        sessionStorage.setItem('activePage', 'inscribirse');
    });
});
// Al cargar la página, verificar si hay una sección activa guardada
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si venimos de una búsqueda con filtros
    const urlParams = new URLSearchParams(window.location.search);
    const hasFilters = urlParams.has('materia') || urlParams.has('tutor');
    
    if (hasFilters) {
        // Si hay filtros en la URL, activar la sección de inscribirse
        activateSection('inscribirse');
    } else if (sessionStorage.getItem('activePage')) {
        // Si hay una página guardada en sessionStorage
        activateSection(sessionStorage.getItem('activePage'));
    }
});

function activateSection(sectionId) {
    // Remover active de todos los enlaces
    document.querySelectorAll('.nav-link').forEach(item => {
        item.classList.remove('active');
    });
    
    // Ocultar todas las páginas
    document.querySelectorAll('.page-section').forEach(page => {
        page.classList.remove('active');
    });
    
    // Activar la sección específica
    const targetLink = document.querySelector(`[data-page="${sectionId}"]`);
    const targetPage = document.getElementById(sectionId);
    
    if (targetLink && targetPage) {
        targetLink.classList.add('active');
        targetPage.classList.add('active');
        document.getElementById('current-page-title').textContent = targetLink.textContent.trim();
        sessionStorage.setItem('activePage', sectionId);
    }
}

// Navegación entre páginas
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        const pageId = this.getAttribute('data-page');
        activateSection(pageId);
    });
});

// Para el formulario de filtros, guardar que estamos en la sección inscribirse
document.getElementById('filtrosForm')?.addEventListener('submit', function() {
    sessionStorage.setItem('activePage', 'inscribirse');
});
        // Inicializar popovers
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
        
        // Ocultar mensajes de alerta después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>