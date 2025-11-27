<<<<<<< HEAD
@php
    // Inicializar todas las variables para evitar errores
    $tutorias_inscritas = $tutorias_inscritas ?? collect([]);
    $historial_tutorias = $historial_tutorias ?? collect([]);
    $tutorias_disponibles = $tutorias_disponibles ?? collect([]);
    $tutorias_inscritas_ids = $tutorias_inscritas_ids ?? []; 
    $materias = $materias ?? collect([]);
    $tutores = $tutores ?? collect([]);
    $proximas_tutorias = $proximas_tutorias ?? collect([]);
    $notificaciones = $notificaciones ?? collect([]);
    $tareas_pendientes = $tareas_pendientes ?? collect([]);
    $solicitudes_recientes = $solicitudes_recientes ?? collect([]);
    $materiales_por_materia = $materiales_por_materia ?? collect([]);
    $materiales_recientes = $materiales_recientes ?? collect([]);
    $evaluaciones_lista = $evaluaciones_lista ?? collect([]);
    
    // Variables del dashboard
    $tutorias_inscritas_count = $tutorias_inscritas_count ?? 0;
    $porcentaje_asistencia = $porcentaje_asistencia ?? 0;
    $promedio_general = $promedio_general ?? 0;
    $tareas_pendientes_count = $tareas_pendientes_count ?? 0;
    $asistencias_presente = $asistencias_presente ?? 0;
    $total_asistencias = $total_asistencias ?? 0;
    
    // Variables de progreso
    $total_tutorias_completadas = $total_tutorias_completadas ?? 0;
    $asistencias_ausente = $asistencias_ausente ?? 0;
    $rendimiento_materias = $rendimiento_materias ?? [];
    $logros = $logros ?? [];
    
    // Enlaces útiles
    $enlaces_utiles = $enlaces_utiles ?? [];
    
    // Sección activa - SIEMPRE usar la del controlador
    $seccion_activa = $seccion ?? 'dashboard';
@endphp
<<<<<<< HEAD

=======
=======
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
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
        
        .progress-sm {
            height: 8px;
        }
        
        .tutoria-card {
            transition: all 0.3s ease;
        }
        
        .tutoria-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
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

>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

=======
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-graduation-cap me-2"></i>Panel del Estudiante</h3>
            </div>
            <div class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ $seccion_activa == 'dashboard' ? 'active' : '' }}" href="{{ route('estudiante.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Mi Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $seccion_activa == 'mistutorias' ? 'active' : '' }}" href="{{ route('estudiante.tutorias') }}">
                            <i class="fas fa-chalkboard-teacher"></i> Mis Tutorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $seccion_activa == 'inscribirse' ? 'active' : '' }}" href="{{ route('estudiante.inscribirse') }}">
                            <i class="fas fa-calendar-plus"></i> Inscribirse en Tutorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $seccion_activa == 'progreso' ? 'active' : '' }}" href="{{ route('estudiante.progreso') }}">
                            <i class="fas fa-chart-line"></i> Mi Progreso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $seccion_activa == 'recursos' ? 'active' : '' }}" href="{{ route('estudiante.recursos') }}">
                            <i class="fas fa-file-alt"></i> Recursos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $seccion_activa == 'solicitudes' ? 'active' : '' }}" href="{{ route('estudiante.solicitudes') }}">
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
                    <h4 class="mb-0" id="current-page-title">
                        @switch($seccion_activa)
                            @case('dashboard') Mi Dashboard @break
                            @case('mistutorias') Mis Tutorías @break
                            @case('inscribirse') Inscribirse en Tutorías @break
                            @case('progreso') Mi Progreso @break
                            @case('recursos') Recursos de Estudio @break
                            @case('solicitudes') Solicitar Ayuda @break
                            @default Mi Dashboard
                        @endswitch
                    </h4>
                </div>
                <div class="user-info">
<<<<<<< HEAD
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
=======
<<<<<<< HEAD
                    <div class="user-avatar">{{ substr($estudiante->name, 0, 2) }}</div>
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
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
=======
                    <div class="user-avatar">AM</div>
                    <div>
                        <div class="fw-bold">Ana Martínez</div>
                        <div class="small text-muted">Estudiante - Ing. Sistemas</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-outline-custom ms-3">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
    </button>
</form>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                <!-- Dashboard Page -->
                <div id="dashboard" class="page-section {{ $seccion_activa == 'dashboard' ? 'active' : '' }}">
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
<<<<<<< HEAD
                                <div class="stats-number">{{ $tutorias_inscritas_count }}</div>
=======
<<<<<<< HEAD
                                <div class="stats-number">{{ $tutorias_inscritas_count ?? 0 }}</div>
=======
                                <div class="stats-number">3</div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                <div class="stats-label">Tutorías Esta Semana</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
<<<<<<< HEAD
                                <div class="stats-number">{{ $porcentaje_asistencia }}%</div>
=======
<<<<<<< HEAD
                                <div class="stats-number">{{ $porcentaje_asistencia ?? 0 }}%</div>
=======
                                <div class="stats-number">92%</div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                <div class="stats-label">Asistencia</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-star"></i>
                                </div>
<<<<<<< HEAD
                                <div class="stats-number">{{ $promedio_general }}</div>
=======
<<<<<<< HEAD
                                <div class="stats-number">{{ $promedio_general ?? 0 }}</div>
=======
                                <div class="stats-number">8.5</div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                <div class="stats-label">Promedio</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
<<<<<<< HEAD
                                <div class="stats-number">{{ $tareas_pendientes_count }}</div>
=======
<<<<<<< HEAD
                                <div class="stats-number">{{ $tareas_pendientes_count ?? 0 }}</div>
=======
                                <div class="stats-number">5</div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                <div class="stats-label">Tareas Pendientes</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-calendar-alt me-2"></i>Mis Próximas Tutorías</span>
                                    <a href="{{ route('estudiante.tutorias') }}" class="btn btn-sm btn-outline-custom">Ver Todas</a>
                                </div>
                                <div class="card-body">
<<<<<<< HEAD
                                    @if($proximas_tutorias->count() > 0)
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
                                                    @foreach($proximas_tutorias as $tutoria)
                                                    @php
                                                        $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                                        $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $tutoria->tema }}</td>
                                                        <td>{{ $tutoria->tutor_name ?? 'Tutor no asignado' }}</td>
                                                        <td>{{ $fecha_formateada }}, {{ $hora_inicio }}</td>
                                                        <td>
                                                            <span class="badge badge-custom 
                                                                {{ $tutoria->estado_inscripcion == 'confirmada' ? 'badge-success' : 
                                                                   ($tutoria->estado_inscripcion == 'pendiente' ? 'badge-warning' : 'badge-secondary') }}">
                                                                {{ ucfirst($tutoria->estado_inscripcion) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-custom btn-ver-detalles" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#detallesTutoriaModal"
                                                                    data-tema="{{ $tutoria->tema }}"
                                                                    data-tutor="{{ $tutoria->tutor_name ?? 'Tutor no asignado' }}"
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
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times"></i>
                                            <h5>No tienes tutorías programadas</h5>
                                            <p>Inscríbete en alguna tutoría disponible para comenzar</p>
                                            <a href="{{ route('estudiante.inscribirse') }}" class="btn btn-custom mt-2">
                                                <i class="fas fa-search me-1"></i> Buscar Tutorías
                                            </a>
                                        </div>
                                    @endif
=======
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
<<<<<<< HEAD
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
=======
                                                <tr>
                                                    <td>Matemáticas Avanzadas</td>
                                                    <td>Dr. Carlos Rodríguez</td>
                                                    <td>Hoy, 10:00 AM</td>
                                                    <td><span class="badge badge-custom badge-success">Inscrito</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Programación en Python</td>
                                                    <td>Ing. María González</td>
                                                    <td>Mañana, 2:00 PM</td>
                                                    <td><span class="badge badge-custom badge-success">Inscrito</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Base de Datos</td>
                                                    <td>Lic. Roberto Silva</td>
                                                    <td>Viernes, 9:00 AM</td>
                                                    <td><span class="badge badge-custom badge-warning">Pendiente</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                                    </td>
                                                </tr>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                                            </tbody>
                                        </table>
                                    </div>
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-bell me-2"></i>Notificaciones Recientes
                                </div>
                                <div class="card-body">
<<<<<<< HEAD
                                    @if($notificaciones->count() > 0)
                                        @foreach($notificaciones as $notificacion)
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-{{ $notificacion->tipo == 'info' ? 'info-circle text-primary' : 
                                                                  ($notificacion->tipo == 'exito' ? 'check-circle text-success' : 'exclamation-triangle text-warning') }}"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-1">{{ $notificacion->mensaje }}</p>
                                                <small class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</small>
                                            </div>
=======
<<<<<<< HEAD
                                    @forelse($notificaciones ?? [] as $notificacion)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-{{ $notificacion->tipo == 'info' ? 'info-circle text-primary' : 
                                                              ($notificacion->tipo == 'exito' ? 'check-circle text-success' : 'exclamation-triangle text-warning') }}"></i>
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="empty-state py-3">
                                            <i class="fas fa-bell-slash"></i>
                                            <p class="mb-0">No hay notificaciones recientes</p>
                                        </div>
<<<<<<< HEAD
                                    @endif
=======
                                    </div>
                                    @empty
                                    <div class="text-center text-muted">
                                        <p>No hay notificaciones recientes</p>
                                    </div>
                                    @endforelse
=======
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Recordatorio: Tutoría de Matemáticas hoy a las 10:00 AM</p>
                                            <small class="text-muted">Hace 2 horas</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Tu solicitud de tutoría ha sido aprobada</p>
                                            <small class="text-muted">Ayer</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Nuevo material disponible para Matemáticas</p>
                                            <small class="text-muted">Hace 3 días</small>
                                        </div>
                                    </div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-tasks me-2"></i>Mis Tareas Pendientes</span>
                                    <span class="badge bg-primary">{{ $tareas_pendientes_count }}</span>
                                </div>
                                <div class="card-body">
<<<<<<< HEAD
                                    @if($tareas_pendientes->count() > 0)
                                        @foreach($tareas_pendientes as $tarea)
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0">
                                                <input class="form-check-input mt-1 tarea-checkbox" type="checkbox" 
                                                       data-tarea-id="{{ $tarea->id }}"
                                                       {{ $tarea->completada ? 'checked' : '' }}>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-1 {{ $tarea->completada ? 'text-decoration-line-through text-muted' : '' }}">
                                                    {{ $tarea->descripcion }}
                                                </p>
                                                <small class="text-muted">
                                                    Para {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}
                                                </small>
                                            </div>
=======
<<<<<<< HEAD
                                    @forelse($tareas_pendientes ?? [] as $tarea)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox" 
                                                   data-tarea-id="{{ $tarea->id }}"
                                                   {{ $tarea->completada ? 'checked' : '' }}>
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="empty-state py-3">
                                            <i class="fas fa-check-double"></i>
                                            <p class="mb-0">No hay tareas pendientes</p>
                                        </div>
<<<<<<< HEAD
                                    @endif
=======
                                    </div>
                                    @empty
                                    <div class="text-center text-muted">
                                        <p>No hay tareas pendientes</p>
                                    </div>
                                    @endforelse
=======
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Resolver ejercicios de derivadas</p>
                                            <small class="text-muted">Para mañana</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Preparar presentación de Python</p>
                                            <small class="text-muted">Para el viernes</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <input class="form-check-input mt-1" type="checkbox" checked>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1 text-decoration-line-through">Revisar material de Base de Datos</p>
                                            <small class="text-muted">Completado</small>
                                        </div>
                                    </div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
<<<<<<< HEAD
                <!-- Mis Tutorías Page -->
                <div id="mistutorias" class="page-section {{ $seccion_activa == 'mistutorias' ? 'active' : '' }}">
                    <div class="page-header">
                        <h1 class="page-title">Mis Tutorías</h1>
                        <p class="text-muted">Gestionar mis sesiones de tutoría</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-list me-2"></i>Tutorías Inscritas
                        </div>
                        <div class="card-body">
                            @if($tutorias_inscritas->count() > 0)
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
                                            @foreach($tutorias_inscritas as $tutoria)
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
                                                            ($tutoria->estado_inscripcion == 'pendiente' ? 'badge-warning' : 'badge-secondary') }}">
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-plus"></i>
                                    <h5>No estás inscrito en ninguna tutoría</h5>
                                    <p>Explora las tutorías disponibles e inscríbete para comenzar</p>
                                    <a href="{{ route('estudiante.inscribirse') }}" class="btn btn-custom mt-2">
                                        <i class="fas fa-search me-1"></i> Buscar Tutorías
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($historial_tutorias->count() > 0)
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
                                        @foreach($historial_tutorias as $tutoria)
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
=======
<<<<<<< HEAD
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
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                
              <!-- Inscribirse Page -->
<div id="inscribirse" class="page-section {{ $seccion_activa == 'inscribirse' ? 'active' : '' }}">
    <div class="page-header">
        <h1 class="page-title">Inscribirse en Tutorías</h1>
        <p class="text-muted">Explora e inscríbete en tutorías disponibles</p>
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
                        <button type="submit" class="btn btn-custom w-100 mb-2">
                            <i class="fas fa-filter me-1"></i> Aplicar Filtros
                        </button>
                        <a href="{{ route('estudiante.inscribirse') }}" class="btn btn-outline-custom w-100">
                            <i class="fas fa-times me-1"></i> Limpiar Filtros
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list me-2"></i>Tutorías Disponibles</span>
                    <span class="badge bg-primary">{{ $tutorias_disponibles->count() }} encontradas</span>
                </div>
                <div class="card-body">
                    @if($tutorias_disponibles->count() > 0)
                        @foreach($tutorias_disponibles as $tutoria)
                            @php
                                $fecha_formateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y');
                                $hora_inicio = \Carbon\Carbon::parse($tutoria->hora_inicio)->format('H:i');
                            @endphp
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $tutoria->tema }}</h5>
                                    <p class="card-text mb-1">
                                        <strong>Tutor:</strong> {{ $tutoria->tutor->name ?? 'Tutor no asignado' }}
                                    </p>
                                    <p class="card-text mb-1">
                                        <strong>Fecha:</strong> {{ $fecha_formateada }}
                                    </p>
                                    <p class="card-text mb-1">
                                        <strong>Hora:</strong> {{ $hora_inicio }}
                                    </p>
                                    <p class="card-text mb-1">
                                        <strong>Modalidad:</strong> 
                                        <span class="badge bg-light text-dark">
                                            {{ $tutoria->modalidad ?? 'Presencial' }}
                                        </span>
                                    </p>
                                    @if($tutoria->observaciones)
                                        <p class="card-text mb-1">
                                            <strong>Observaciones:</strong> {{ $tutoria->observaciones }}
                                        </p>
                                    @endif
                                    
                                    <div class="mt-3">
                                        <form method="POST" action="{{ route('estudiante.inscribir-tutoria', $tutoria->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-custom btn-lg w-100">
                                                <i class="fas fa-plus me-2"></i> INSCRIBIRSE 
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h5>No hay tutorías disponibles</h5>
                            <p>No se encontraron tutorías con los filtros seleccionados</p>
                            <a href="{{ route('estudiante.inscribirse') }}" class="btn btn-outline-custom mt-2">
                                <i class="fas fa-times me-1"></i> Limpiar Filtros
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
=======
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
                                            <th>Modalidad</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Matemáticas Avanzadas</td>
                                            <td>Dr. Carlos Rodríguez</td>
                                            <td>15/11/2025 10:00</td>
                                            <td>Presencial</td>
                                            <td><span class="badge badge-custom badge-success">Activa</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Ver Detalles</button>
                                                <button class="btn btn-sm btn-outline-custom">Cancelar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Programación en Python</td>
                                            <td>Ing. María González</td>
                                            <td>16/11/2025 14:00</td>
                                            <td>Virtual</td>
                                            <td><span class="badge badge-custom badge-success">Activa</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Ver Detalles</button>
                                                <button class="btn btn-sm btn-outline-custom">Cancelar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Base de Datos</td>
                                            <td>Lic. Roberto Silva</td>
                                            <td>17/11/2025 09:00</td>
                                            <td>Mixta</td>
                                            <td><span class="badge badge-custom badge-warning">Pendiente</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Ver Detalles</button>
                                                <button class="btn btn-sm btn-outline-custom">Cancelar</button>
                                            </td>
                                        </tr>
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
                                            <th>Asistencia</th>
                                            <th>Material</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Matemáticas Básicas</td>
                                            <td>Dr. Carlos Rodríguez</td>
                                            <td>10/11/2025</td>
                                            <td><span class="badge badge-custom badge-success">Presente</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Introducción a Python</td>
                                            <td>Ing. María González</td>
                                            <td>08/11/2025</td>
                                            <td><span class="badge badge-custom badge-success">Presente</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SQL Básico</td>
                                            <td>Lic. Roberto Silva</td>
                                            <td>05/11/2025</td>
                                            <td><span class="badge badge-custom badge-danger">Ausente</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </td>
                                        </tr>
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
                    
                    <!-- Tutorías Invitadas -->
                    <div class="card mb-4 invitation-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-envelope me-2"></i>Tutorías Invitadas</span>
                            <span class="badge badge-custom badge-primary">3 nuevas</span>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Los tutores te han invitado directamente a estas tutorías. Puedes aceptar o rechazar la invitación.</p>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tutoría</th>
                                            <th>Tutor</th>
                                            <th>Fecha y Hora</th>
                                            <th>Modalidad</th>
                                            <th>Mensaje del Tutor</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Matemáticas Avanzadas - Grupo Especial</td>
                                            <td>Dr. Carlos Rodríguez</td>
                                            <td>18/11/2025 16:00</td>
                                            <td>Presencial</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Hola Ana, he notado tu excelente rendimiento en matemáticas y me gustaría invitarte a este grupo especial para profundizar en temas avanzados. Espero puedas asistir.">
                                                    <i class="fas fa-comment"></i> Ver Mensaje
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success me-1">
                                                    <i class="fas fa-check"></i> Aceptar
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Rechazar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Preparación para Examen Final</td>
                                            <td>Ing. María González</td>
                                            <td>20/11/2025 10:00</td>
                                            <td>Virtual</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Ana, he organizado esta sesión especial de repaso para el examen final. Sería ideal que participes para reforzar los conceptos clave.">
                                                    <i class="fas fa-comment"></i> Ver Mensaje
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success me-1">
                                                    <i class="fas fa-check"></i> Aceptar
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Rechazar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Proyecto Integrador - Asesoría</td>
                                            <td>Lic. Roberto Silva</td>
                                            <td>22/11/2025 14:00</td>
                                            <td>Mixta</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Hola Ana, he revisado tu progreso y creo que esta sesión te ayudará con el proyecto integrador. Espero contar con tu participación.">
                                                    <i class="fas fa-comment"></i> Ver Mensaje
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success me-1">
                                                    <i class="fas fa-check"></i> Aceptar
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Rechazar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-filter me-2"></i>Filtrar Tutorías
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="filtroMateria" class="form-label">Materia</label>
                                        <select class="form-select" id="filtroMateria">
                                            <option selected>Todas las materias</option>
                                            <option>Matemáticas</option>
                                            <option>Programación</option>
                                            <option>Base de Datos</option>
                                            <option>Estadística</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filtroModalidad" class="form-label">Modalidad</label>
                                        <select class="form-select" id="filtroModalidad">
                                            <option selected>Todas las modalidades</option>
                                            <option>Presencial</option>
                                            <option>Virtual</option>
                                            <option>Mixta</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filtroTutor" class="form-label">Tutor</label>
                                        <select class="form-select" id="filtroTutor">
                                            <option selected>Todos los tutores</option>
                                            <option>Dr. Carlos Rodríguez</option>
                                            <option>Ing. María González</option>
                                            <option>Lic. Roberto Silva</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-custom w-100">Aplicar Filtros</button>
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
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title">Matemáticas Avanzadas</h5>
                                                    <p class="card-text"><strong>Tutor:</strong> Dr. Carlos Rodríguez</p>
                                                    <p class="card-text"><strong>Fecha:</strong> 18/11/2025 10:00</p>
                                                    <p class="card-text"><strong>Modalidad:</strong> Presencial</p>
                                                    <p class="card-text"><strong>Cupos:</strong> 5/12</p>
                                                    <div class="d-grid">
                                                        <button class="btn btn-custom">Inscribirse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title">Programación en Python</h5>
                                                    <p class="card-text"><strong>Tutor:</strong> Ing. María González</p>
                                                    <p class="card-text"><strong>Fecha:</strong> 19/11/2025 14:00</p>
                                                    <p class="card-text"><strong>Modalidad:</strong> Virtual</p>
                                                    <p class="card-text"><strong>Cupos:</strong> 8/15</p>
                                                    <div class="d-grid">
                                                        <button class="btn btn-custom">Inscribirse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title">Base de Datos Avanzada</h5>
                                                    <p class="card-text"><strong>Tutor:</strong> Lic. Roberto Silva</p>
                                                    <p class="card-text"><strong>Fecha:</strong> 20/11/2025 09:00</p>
                                                    <p class="card-text"><strong>Modalidad:</strong> Mixta</p>
                                                    <p class="card-text"><strong>Cupos:</strong> 3/10</p>
                                                    <div class="d-grid">
                                                        <button class="btn btn-custom">Inscribirse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title">Estadística Aplicada</h5>
                                                    <p class="card-text"><strong>Tutor:</strong> Dr. Carlos Rodríguez</p>
                                                    <p class="card-text"><strong>Fecha:</strong> 21/11/2025 11:00</p>
                                                    <p class="card-text"><strong>Modalidad:</strong> Virtual</p>
                                                    <p class="card-text"><strong>Cupos:</strong> 12/20</p>
                                                    <div class="d-grid">
                                                        <button class="btn btn-custom">Inscribirse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                <!-- Progreso Page -->
                <div id="progreso" class="page-section {{ $seccion_activa == 'progreso' ? 'active' : '' }}">
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
<<<<<<< HEAD
                                            <h3 class="text-primary">{{ $porcentaje_asistencia }}%</h3>
=======
<<<<<<< HEAD
                                            <h3 class="text-primary">{{ $porcentaje_asistencia ?? 0 }}%</h3>
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                            <p class="text-muted">Asistencia</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="text-success">{{ $promedio_general }}</h3>
                                            <p class="text-muted">Promedio General</p>
                                        </div>
                                        <div class="col-md-4">
<<<<<<< HEAD
                                            <h3 class="text-info">{{ $total_tutorias_completadas }}</h3>
=======
                                            <h3 class="text-info">{{ $total_tutorias_completadas ?? 0 }}</h3>
=======
                                            <h3 class="text-primary">92%</h3>
                                            <p class="text-muted">Asistencia</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="text-success">8.5</h3>
                                            <p class="text-muted">Promedio General</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="text-info">15</h3>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                            <p class="text-muted">Tutorías Completadas</p>
                                        </div>
                                    </div>
                                    
<<<<<<< HEAD
                                    @if(count($rendimiento_materias) > 0)
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
                                    @else
                                        <div class="empty-state py-4">
                                            <i class="fas fa-chart-bar"></i>
                                            <h5>No hay datos de rendimiento</h5>
                                            <p>Completa algunas tutorías para ver tu progreso</p>
                                        </div>
                                    @endif
=======
                                    <h5 class="mb-3">Rendimiento por Materia</h5>
<<<<<<< HEAD
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
=======
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Matemáticas</span>
                                            <span>8.7/10</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 87%"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Programación</span>
                                            <span>8.5/10</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 85%"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Base de Datos</span>
                                            <span>7.8/10</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning" style="width: 78%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Estadística</span>
                                            <span>9.0/10</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 90%"></div>
                                        </div>
                                    </div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
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
<<<<<<< HEAD
                                        <h3 class="text-primary">{{ $porcentaje_asistencia }}%</h3>
=======
<<<<<<< HEAD
                                        <h3 class="text-primary">{{ $porcentaje_asistencia ?? 0 }}%</h3>
=======
                                        <h3 class="text-primary">92%</h3>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                        <p class="text-muted">Asistencia General</p>
                                    </div>
                                    <div class="d-flex justify-content-around mb-3">
                                        <div>
<<<<<<< HEAD
                                            <h5 class="text-success">{{ $asistencias_presente }}</h5>
                                            <small>Presente</small>
                                        </div>
                                        <div>
                                            <h5 class="text-danger">{{ $asistencias_ausente }}</h5>
=======
<<<<<<< HEAD
                                            <h5 class="text-success">{{ $asistencias_presente ?? 0 }}</h5>
                                            <small>Presente</small>
                                        </div>
                                        <div>
                                            <h5 class="text-danger">{{ $asistencias_ausente ?? 0 }}</h5>
=======
                                            <h5 class="text-success">23</h5>
                                            <small>Presente</small>
                                        </div>
                                        <div>
                                            <h5 class="text-danger">2</h5>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                            <small>Ausente</small>
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px;">
<<<<<<< HEAD
                                        <div class="progress-bar bg-success" style="width: {{ $porcentaje_asistencia }}%"></div>
                                    </div>
                                    <small class="text-muted">Basado en {{ $total_asistencias }} tutorías</small>
=======
<<<<<<< HEAD
                                        <div class="progress-bar bg-success" style="width: {{ $porcentaje_asistencia ?? 0 }}%"></div>
                                    </div>
                                    <small class="text-muted">Basado en {{ $total_asistencias ?? 0 }} tutorías</small>
=======
                                        <div class="progress-bar bg-success" style="width: 92%"></div>
                                    </div>
                                    <small class="text-muted">Basado en 25 tutorías</small>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                </div>
                            </div>
                            
                            @if(count($logros) > 0)
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-award me-2"></i>Logros
                                </div>
                                <div class="card-body">
<<<<<<< HEAD
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
=======
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-medal text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Asistencia Perfecta</p>
                                            <small class="text-muted">Asististe a 10 tutorías consecutivas</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-star text-info"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Excelente Rendimiento</p>
                                            <small class="text-muted">Promedio mayor a 8.5 en Matemáticas</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-trophy text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Participación Activa</p>
                                            <small class="text-muted">Completaste 15 tutorías</small>
                                        </div>
                                    </div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
<<<<<<< HEAD
                    @if($evaluaciones_lista->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <i class="fas fa-history me-2"></i>Historial de Evaluaciones
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Materia</th> 
                        <th>Tutor</th>
                        <th>Fecha</th>
                        <th>Calificación</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluaciones_lista as $evaluacion)
                    @php
                        $fecha_formateada = \Carbon\Carbon::parse($evaluacion->fecha_evaluacion)->format('d/m/Y');
                    @endphp
                    <tr>
                        <td>{{ $evaluacion->materia }}</td> <!-- Usa materia en lugar de tema -->
                        <td>{{ $evaluacion->tutor_name ?? 'Tutor no asignado' }}</td>
                        <td>{{ $fecha_formateada }}</td>
                        <td>
                            <span class="badge 
                                {{ $evaluacion->calificacion >= 8 ? 'bg-success' : 
                                   ($evaluacion->calificacion >= 6 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $evaluacion->calificacion }}
                            </span>
                        </td>
                        <td>{{ $evaluacion->comentarios ?? 'Sin comentarios' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
                </div>
                
               <!-- Recursos Page -->
<div id="recursos" class="page-section {{ $seccion_activa == 'recursos' ? 'active' : '' }}">
    <div class="page-header">
        <h1 class="page-title">Recursos</h1>
        <p class="text-muted">Materiales y recursos para las tutorías</p>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-folder me-2"></i>Recursos Disponibles</span>
            <span class="badge bg-primary">{{ $materiales_recientes->count() ?? 0 }} recursos</span>
        </div>
        <div class="card-body">
            <div class="row" id="listaRecursos">
                @if($materiales_recientes->count() > 0)
                    @foreach($materiales_recientes as $recurso)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                @php
                                    $extension = pathinfo($recurso->archivo ?? $recurso->file_path ?? '', PATHINFO_EXTENSION);
                                    $tipo = strtolower($extension);
                                @endphp
                                
                                @if(in_array($tipo, ['pdf']))
                                    <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                @elseif(in_array($tipo, ['ppt', 'pptx']))
                                    <i class="fas fa-file-powerpoint fa-3x text-warning mb-3"></i>
                                @elseif(in_array($tipo, ['mp4', 'avi', 'mov', 'wmv']))
                                    <i class="fas fa-file-video fa-3x text-primary mb-3"></i>
                                @elseif(in_array($tipo, ['doc', 'docx']))
                                    <i class="fas fa-file-word fa-3x text-info mb-3"></i>
                                @elseif(in_array($tipo, ['xls', 'xlsx']))
                                    <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                                @elseif($recurso->enlace)
                                    <i class="fas fa-link fa-3x text-success mb-3"></i>
                                @else
                                    <i class="fas fa-file fa-3x text-secondary mb-3"></i>
                                @endif
                                
                                <h5>{{ $recurso->nombre ?? $recurso->name ?? 'Sin nombre' }}</h5>
                                <p class="text-muted">{{ $extension ? strtoupper($extension) : 'Archivo' }}</p>
                                <p class="small">{{ $recurso->descripcion ?? 'Recurso de estudio' }}</p>
                                <div class="d-grid gap-2">
                                    @if($recurso->archivo)
                                        <a href="{{ route('estudiante.recursos.download', $recurso->id) }}" 
                                        class="btn btn-outline-custom btn-sm" 
                                        download>
                                            Descargar
                                        </a>
                                    @else
                                        <span class="text-muted">No disponible</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                Subido: {{ \Carbon\Carbon::parse($recurso->created_at ?? now())->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <h5>No hay recursos disponibles</h5>
                            <p>Los tutores subirán materiales pronto</p>
                        </div>
                    </div>
                @endif
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
=======
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
<<<<<<< HEAD
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
=======
                                        <tr>
                                            <td>Matemáticas Avanzadas</td>
                                            <td>Dr. Carlos Rodríguez</td>
                                            <td>10/11/2025</td>
                                            <td>9.0</td>
                                            <td>Excelente comprensión de los conceptos</td>
                                        </tr>
                                        <tr>
                                            <td>Programación Python</td>
                                            <td>Ing. María González</td>
                                            <td>08/11/2025</td>
                                            <td>8.5</td>
                                            <td>Buen trabajo en los ejercicios prácticos</td>
                                        </tr>
                                        <tr>
                                            <td>Base de Datos</td>
                                            <td>Lic. Roberto Silva</td>
                                            <td>05/11/2025</td>
                                            <td>7.5</td>
                                            <td>Necesita practicar más consultas complejas</td>
                                        </tr>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
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
<<<<<<< HEAD
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
=======
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-calculator fa-3x text-primary mb-3"></i>
                                            <h5>Matemáticas</h5>
                                            <p class="text-muted">5 archivos disponibles</p>
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-outline-custom btn-sm">Explorar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-code fa-3x text-success mb-3"></i>
                                            <h5>Programación</h5>
                                            <p class="text-muted">8 archivos disponibles</p>
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-outline-custom btn-sm">Explorar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-database fa-3x text-warning mb-3"></i>
                                            <h5>Base de Datos</h5>
                                            <p class="text-muted">3 archivos disponibles</p>
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-outline-custom btn-sm">Explorar</button>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                                            </div>
                                        </div>
                                    </div>
                                </div>
<<<<<<< HEAD
                                @endforeach
=======
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
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
<<<<<<< HEAD
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
=======
                                        <tr>
                                            <td>Guía de Ejercicios - Derivadas</td>
                                            <td>Matemáticas</td>
                                            <td>PDF</td>
                                            <td>10/11/2025</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ejemplos de Código Python</td>
                                            <td>Programación</td>
                                            <td>ZIP</td>
                                            <td>08/11/2025</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Video - Consultas SQL Avanzadas</td>
                                            <td>Base de Datos</td>
                                            <td>MP4</td>
                                            <td>05/11/2025</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom">
                                                    <i class="fas fa-play"></i> Ver
                                                </button>
                                            </td>
                                        </tr>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
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
<<<<<<< HEAD
                                @foreach($enlaces_utiles as $enlace)
                                <a href="{{ $enlace['url'] ?? '#' }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    {{ $enlace['nombre'] ?? 'Enlace' }}
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endforeach
=======
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Khan Academy - Matemáticas
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    W3Schools - Programación
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    SQLZoo - Práctica de SQL
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                            </div>
                        </div>
                    </div>
                </div>
                
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                <!-- Solicitudes Page -->
                <div id="solicitudes" class="page-section {{ $seccion_activa == 'solicitudes' ? 'active' : '' }}">
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
<<<<<<< HEAD
                                    <form method="POST" action="{{ route('estudiante.solicitudes.crear') }}" id="solicitudForm">
=======
<<<<<<< HEAD
                                    <form method="POST" action="{{ route('estudiante.solicitudes.crear') }}">
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                        @csrf
                                        <div class="mb-3">
                                            <label for="tipoSolicitud" class="form-label">Tipo de Solicitud</label>
                                            <select class="form-select" id="tipoSolicitud" name="tipo" required>
                                                <option value="">Seleccione el tipo de solicitud...</option>
=======
                                    <form>
                                        <div class="mb-3">
                                            <label for="tipoSolicitud" class="form-label">Tipo de Solicitud</label>
                                            <select class="form-select" id="tipoSolicitud">
                                                <option selected>Seleccione el tipo de solicitud...</option>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                                                <option value="tutoria">Tutoría Personalizada</option>
                                                <option value="material">Material Adicional</option>
                                                <option value="duda">Consulta Específica</option>
                                                <option value="otro">Otro</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="materiaSolicitud" class="form-label">Materia</label>
<<<<<<< HEAD
                                            <select class="form-select" id="materiaSolicitud" name="materia" required>
                                                <option value="">Seleccione una materia...</option>
                                                @foreach($materias as $materia)
                                                <option value="{{ $materia }}">{{ $materia }}</option>
                                                @endforeach
=======
                                            <select class="form-select" id="materiaSolicitud">
                                                <option selected>Seleccione una materia...</option>
                                                <option>Matemáticas</option>
                                                <option>Programación</option>
                                                <option>Base de Datos</option>
                                                <option>Estadística</option>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tutorPreferido" class="form-label">Tutor Preferido (Opcional)</label>
<<<<<<< HEAD
                                            <select class="form-select" id="tutorPreferido" name="id_tutor">
                                                <option value="">Sin preferencia</option>
                                                @foreach($tutores as $tutor)
                                                <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                                @endforeach
=======
                                            <select class="form-select" id="tutorPreferido">
                                                <option selected>Sin preferencia</option>
                                                <option>Dr. Carlos Rodríguez</option>
                                                <option>Ing. María González</option>
                                                <option>Lic. Roberto Silva</option>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="descripcionSolicitud" class="form-label">Descripción</label>
<<<<<<< HEAD
                                            <textarea class="form-control" id="descripcionSolicitud" name="descripcion" rows="4" placeholder="Describe detalladamente tu solicitud..." required></textarea>
                                            <div class="form-text">Sé específico sobre lo que necesitas ayuda.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="urgenciaSolicitud" class="form-label">Nivel de Urgencia</label>
                                            <select class="form-select" id="urgenciaSolicitud" name="urgencia" required>
=======
                                            <textarea class="form-control" id="descripcionSolicitud" rows="4" placeholder="Describe detalladamente tu solicitud..."></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="urgenciaSolicitud" class="form-label">Nivel de Urgencia</label>
                                            <select class="form-select" id="urgenciaSolicitud">
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                                                <option value="baja">Baja</option>
                                                <option value="media" selected>Media</option>
                                                <option value="alta">Alta</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-custom" id="btnEnviarSolicitud">
                                            <i class="fas fa-paper-plane me-1"></i> Enviar Solicitud
                                        </button>
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
<<<<<<< HEAD
                                    @if($solicitudes_recientes->count() > 0)
                                        @foreach($solicitudes_recientes as $solicitud)
                                        <div class="mb-3 pb-3 border-bottom">
                                            <h6 class="mb-1">{{ ucfirst($solicitud->tipo) }} - {{ $solicitud->materia }}</h6>
                                            <p class="mb-1 small text-muted">{{ Str::limit($solicitud->descripcion, 50) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}</small>
                                                <span class="badge badge-custom 
                                                    {{ $solicitud->estado == 'aprobado' ? 'badge-success' : 
                                                       ($solicitud->estado == 'en_proceso' ? 'badge-warning' : 'badge-info') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $solicitud->estado)) }}
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="empty-state py-3">
                                            <i class="fas fa-inbox"></i>
                                            <p class="mb-0">No hay solicitudes recientes</p>
                                        </div>
                                    @endif
=======
<<<<<<< HEAD
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
=======
                                    <div class="mb-3">
                                        <h6>Tutoría de Matemáticas</h6>
                                        <p class="mb-1 small">Solicitado: 10/11/2025</p>
                                        <span class="badge badge-custom badge-success">Aprobado</span>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Material adicional de Python</h6>
                                        <p class="mb-1 small">Solicitado: 08/11/2025</p>
                                        <span class="badge badge-custom badge-warning">En Proceso</span>
                                    </div>
                                    <div>
                                        <h6>Consulta sobre SQL</h6>
                                        <p class="mb-1 small">Solicitado: 05/11/2025</p>
                                        <span class="badge badge-custom badge-success">Resuelto</span>
                                    </div>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-2"></i>Información de Contacto
                                </div>
                                <div class="card-body">
                                    <p class="small">Si necesitas ayuda inmediata, puedes contactar a:</p>
                                    <ul class="list-unstyled small">
                                        <li><strong>Coordinador de Tutorías:</strong></li>
                                        <li>Lic. Rodrigo Vera</li>
                                        <li><i class="fas fa-envelope me-1"></i> r.vera@univalle.edu</li>
                                        <li><i class="fas fa-phone me-1"></i> Ext. 1234</li>
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
<<<<<<< HEAD
                <div class="modal-body" id="detalles-tutoria-body">
                    <!-- Los detalles se cargarán dinámicamente -->
=======
                <div class="modal-body">
                    <h5>Matemáticas Avanzadas</h5>
                    <p><strong>Tutor:</strong> Dr. Carlos Rodríguez</p>
                    <p><strong>Fecha y Hora:</strong> 15/11/2025, 10:00 AM</p>
                    <p><strong>Modalidad:</strong> Presencial</p>
                    <p><strong>Ubicación:</strong> Aula 302, Edificio Principal</p>
                    <p><strong>Duración:</strong> 2 horas</p>
                    <p><strong>Temas a tratar:</strong></p>
                    <ul>
                        <li>Derivadas parciales</li>
                        <li>Integrales múltiples</li>
                        <li>Aplicaciones prácticas</li>
                    </ul>
                    <p><strong>Material requerido:</strong> Calculadora científica, cuaderno de ejercicios</p>
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
     // Manejo de formularios de inscripción - versión simplificada
document.addEventListener('DOMContentLoaded', function() {
    // Los formularios se enviarán normalmente, el JavaScript solo es para feedback visual
    const forms = document.querySelectorAll('form[action*="inscribir-tutoria"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            
            // Mostrar loading
            button.disabled = true;
            button.innerHTML = '<span class="loading-spinner"></span> Inscribiendo...';
            
            // El formulario se enviará normalmente
            // No prevenimos el envío predeterminado
        });
<<<<<<< HEAD
    });
});
=======
        
<<<<<<< HEAD
>>>>>>> 2991380dec6648461d490936fe6b2ec1fbae4891
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
                    <div class="mb-3">
                        <strong><i class="fas fa-user me-2"></i>Tutor:</strong> ${tutor}
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-calendar me-2"></i>Fecha y Hora:</strong> ${fecha}, ${hora}
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-laptop me-2"></i>Modalidad:</strong> ${modalidad}
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-map-marker-alt me-2"></i>Ubicación:</strong> ${ubicacion || 'Por definir'}
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-clock me-2"></i>Duración:</strong> ${duracion || 'Por definir'}
                    </div>
                    ${observaciones && observaciones !== 'Sin observaciones' ? `
                    <div class="mb-3">
                        <strong><i class="fas fa-sticky-note me-2"></i>Observaciones:</strong> 
                        <div class="alert alert-light mt-2">${observaciones}</div>
                    </div>` : ''}
                `;
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
=======
        // Simular funcionalidad de inscripción
        document.querySelectorAll('.btn-custom').forEach(button => {
            if (button.textContent.includes('Inscribirse')) {
                button.addEventListener('click', function() {
                    alert('Te has inscrito correctamente en la tutoría');
                    this.textContent = 'Inscrito';
                    this.disabled = true;
                    this.classList.remove('btn-custom');
                    this.classList.add('btn-outline-custom');
                });
            }
        });
        
        // Simular funcionalidad de enviar solicitud
        document.querySelectorAll('.btn-custom').forEach(button => {
            if (button.textContent.includes('Enviar Solicitud')) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Tu solicitud ha sido enviada correctamente');
                });
            }
        });
        
        // Simular funcionalidad de ver detalles
        document.querySelectorAll('.btn-outline-custom').forEach(button => {
            if (button.textContent.includes('Ver Detalles')) {
                button.addEventListener('click', function() {
                    // En una implementación real, esto mostraría un modal con los detalles específicos
                    const modal = new bootstrap.Modal(document.getElementById('detallesTutoriaModal'));
                    modal.show();
                });
            }
        });
        
        // Simular funcionalidad de cancelar tutoría
        document.querySelectorAll('.btn-outline-custom').forEach(button => {
            if (button.textContent.includes('Cancelar')) {
                button.addEventListener('click', function() {
                    if (confirm('¿Estás seguro de que quieres cancelar tu inscripción en esta tutoría?')) {
                        alert('Tu inscripción ha sido cancelada');
                        // En una implementación real, aquí se eliminaría la tutoría de la lista
                        const row = this.closest('tr');
                        row.remove();
                    }
                });
            }
        });
        
        // Funcionalidad para aceptar/rechazar invitaciones
        document.querySelectorAll('.btn-success').forEach(button => {
            if (button.textContent.includes('Aceptar')) {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const tutoria = row.cells[0].textContent;
                    const tutor = row.cells[1].textContent;
                    
                    if (confirm(`¿Aceptar la invitación para "${tutoria}" con ${tutor}?`)) {
                        alert('Invitación aceptada. Has sido agregado a la tutoría.');
                        row.remove();
                    }
                });
            }
        });
        
        document.querySelectorAll('.btn-danger').forEach(button => {
            if (button.textContent.includes('Rechazar')) {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const tutoria = row.cells[0].textContent;
                    const tutor = row.cells[1].textContent;
                    
                    if (confirm(`¿Rechazar la invitación para "${tutoria}" con ${tutor}?`)) {
                        alert('Invitación rechazada.');
                        row.remove();
                    }
                });
            }
        });
        
        // Inicializar popovers de Bootstrap
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
    </script>
</body>
</html>