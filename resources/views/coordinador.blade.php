<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Tutorías - Panel Principal</title>
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
                <h3><i class="fas fa-graduation-cap me-2"></i>Sistema de Tutorías</h3>
            </div>
            <div class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('coordinador.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('coordinador.tutorias') }}">
                            <i class="fas fa-chalkboard-teacher"></i> Gestión de Tutorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('coordinador.asistencia') }}">
                            <i class="fas fa-clipboard-check"></i> Control de Asistencia
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('coordinador.reportes') }}">
                        <i class="fas fa-chart-bar"></i> Reportes
                    </a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('coordinador.estudiantes') }}">
                            <i class="fas fa-user-graduate"></i> Estudiantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('coordinador.tutores') }}">
                            <i class="fas fa-users"></i> Tutores
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
                        @if(request()->routeIs('coordinador.tutorias'))
                            Gestión de Tutorías
                        @elseif(request()->routeIs('coordinador.estudiantes'))
                            Gestión de Estudiantes
                        @elseif(request()->routeIs('coordinador.tutores'))
                            Gestión de Tutores
                        @elseif(request()->routeIs('coordinador.asistencia'))
                            Control de Asistencia
                        @elseif(request()->routeIs('coordinador.reportes'))
                            Reportes
                        @else
                            Dashboard
                        @endif
                    </h4>
                </div>
                <div class="user-info">
                    <div class="user-avatar">{{ substr($coordinador->name, 0, 2) }}</div>
                    <div>
                        <div class="fw-bold">{{ $coordinador->name }}</div>
                        <div class="small text-muted">Coordinador</div>
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
                @if(request()->routeIs('coordinador.dashboard') || request()->routeIs('coordinador'))
                <div id="dashboard" class="page-section active">
                    <div class="page-header">
                        <h1 class="page-title">Dashboard Principal</h1>
                        <p class="text-muted">Resumen del sistema de gestión de tutorías</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="stats-number">{{ $tutoriasActivas }}</div>
                                <div class="stats-label">Tutorías Activas</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="stats-number">{{ $totalEstudiantes }}</div>
                                <div class="stats-label">Estudiantes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stats-number">{{ $totalTutores }}</div>
                                <div class="stats-label">Tutores</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="stats-number">{{ $asistenciaPromedio }}%</div>
                                <div class="stats-label">Asistencia Promedio</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
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
                                                    <th>Tutor</th>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($proximasTutorias as $tutoria)
                                                @php
                                                    $fechaFormateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y H:i');
                                                @endphp
                                                <tr>
                                                    <td>{{ $tutoria->tema }}</td>
                                                    <td>{{ $tutoria->tutor->name ?? 'Tutor no asignado' }}</td>
                                                    <td>{{ $fechaFormateada }}</td>
                                                    <td>
                                                        <span class="badge badge-custom 
                                                            {{ $tutoria->estado == 'activa' ? 'badge-success' : 
                                                               ($tutoria->estado == 'pendiente' ? 'badge-warning' : 'badge-danger') }}">
                                                            {{ ucfirst($tutoria->estado) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom btn-ver-detalles-tutoria" 
                                                                data-tema="{{ $tutoria->tema }}"
                                                                data-tutor="{{ $tutoria->tutor->name ?? 'Tutor no asignado' }}"
                                                                data-fecha="{{ $fechaFormateada }}"
                                                                data-modalidad="{{ $tutoria->modalidad ?? 'No especificado' }}"
                                                                data-estado="{{ $tutoria->estado }}"
                                                                data-descripcion="{{ $tutoria->observaciones ?? 'Sin descripción' }}">
                                                            Ver Detalles
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No hay tutorías programadas</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-bell me-2"></i>Solicitudes Pendientes
                                </div>
                                <div class="card-body">
                                    @forelse($solicitudesPendientes as $solicitud)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">{{ $solicitud->tipo ?? 'Solicitud' }} - {{ $solicitud->materia ?? 'General' }}</p>
                                            <small class="text-muted">{{ $solicitud->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center text-muted">
                                        <p>No hay solicitudes pendientes</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Tutorías Page -->
                @if(request()->routeIs('coordinador.tutorias'))
                <div id="tutorias" class="page-section active">
                    <div class="page-header">
                        <h1 class="page-title">Gestión de Tutorías</h1>
                        <p class="text-muted">Administrar y programar sesiones de tutoría</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"></i>Lista de Tutorías</span>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#crearTutoriaModal">
                                <i class="fas fa-plus me-1"></i> Nueva Tutoría
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Tutor</th>
                                            <th>Fecha</th>
                                            <th>Modalidad</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tutorias as $tutoria)
                                        @php
                                            $fechaFormateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y H:i');
                                        @endphp
                                        <tr>
                                            <td>{{ $tutoria->id }}</td>
                                            <td>{{ $tutoria->tema }}</td>
                                            <td>{{ $tutoria->tutor->name ?? 'Tutor no asignado' }}</td>
                                            <td>{{ $fechaFormateada }}</td>
                                            <td>{{ ucfirst($tutoria->modalidad) }}</td>
                                            <td>
                                                <span class="badge badge-custom 
                                                    {{ $tutoria->estado == 'activa' ? 'badge-success' : 
                                                       ($tutoria->estado == 'pendiente' ? 'badge-warning' : 'badge-danger') }}">
                                                    {{ ucfirst($tutoria->estado) }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1 btn-editar-tutoria" 
                                                        data-id="{{ $tutoria->id }}"
                                                        data-tema="{{ $tutoria->tema }}"
                                                        data-tutor="{{ $tutoria->id_tutor }}"
                                                        data-fecha="{{ $tutoria->fecha }}"
                                                        data-hora="{{ $tutoria->hora_inicio }}"
                                                        data-modalidad="{{ $tutoria->modalidad }}"
                                                        data-estado="{{ $tutoria->estado }}"
                                                        data-descripcion="{{ $tutoria->observaciones }}">
                                                    Editar
                                                </button>
                                                @if($tutoria->estado != 'cancelada')
                                                <form method="POST" action="{{ route('coordinador.tutorias.eliminar', $tutoria->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-custom" 
                                                            onclick="return confirm('¿Está seguro de que desea cancelar esta tutoría?')">
                                                        Cancelar
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No hay tutorías registradas</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Asistencia Page -->
                @if(request()->routeIs('coordinador.asistencia'))
                <div id="asistencia" class="page-section active">
                    <div class="page-header">
                        <h1 class="page-title">Control de Asistencia</h1>
                        <p class="text-muted">Registrar y gestionar la asistencia a tutorías</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-clipboard-list me-2"></i>Registro de Asistencia
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="selectTutoria" class="form-label">Seleccionar Tutoría</label>
                                        <select class="form-select" id="selectTutoria">
                                            <option value="" selected>Seleccione una tutoría...</option>
                                            @foreach($tutorias as $tutoria)
                                                @if($tutoria->estado == 'activa' || $tutoria->estado == 'pendiente')
                                                @php
                                                    $fechaFormateada = \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y H:i');
                                                @endphp
                                                <option value="{{ $tutoria->id }}">
                                                    {{ $tutoria->tema }} - {{ $fechaFormateada }} ({{ $tutoria->tutor->name ?? 'Sin tutor' }})
                                                </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div id="tabla-asistencia-container" style="display: none;">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla-asistencia">
                                                <thead>
                                                    <tr>
                                                        <th>Estudiante</th>
                                                        <th>Email</th>
                                                        <th>Asistencia</th>
                                                        <th>Observaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="estudiantes-tutoria">
                                                    <!-- Los estudiantes se cargarán dinámicamente -->
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-custom" id="btn-guardar-asistencia">
                                                <i class="fas fa-save me-1"></i> Guardar Asistencia
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-2"></i>Resumen de Asistencia
                                </div>
                                <div class="card-body text-center">
                                    @php
                                        $totalAsistencias = App\Models\Asistencia::count();
                                        $asistenciasPresente = App\Models\Asistencia::where('asistio', true)->count();
                                        $asistenciaPromedio = $totalAsistencias > 0 ? round(($asistenciasPresente / $totalAsistencias) * 100) : 0;
                                    @endphp
                                    <div class="mb-4">
                                        <h3 class="text-primary">{{ $asistenciaPromedio }}%</h3>
                                        <p class="text-muted">Asistencia General</p>
                                    </div>
                                    <div class="d-flex justify-content-around mb-3">
                                        <div>
                                            <h5 class="text-success">{{ $asistenciasPresente }}</h5>
                                            <small>Presentes</small>
                                        </div>
                                        <div>
                                            <h5 class="text-danger">{{ $totalAsistencias - $asistenciasPresente }}</h5>
                                            <small>Ausentes</small>
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-success" style="width: {{ $asistenciaPromedio }}%"></div>
                                    </div>
                                    <small class="text-muted">Basado en {{ $totalAsistencias }} registros</small>
                                </div>
                            </div>

                            <!-- Tutorías Recientes -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-history me-2"></i>Tutorías Recientes
                                </div>
                                <div class="card-body">
                                    @foreach($tutorias->take(3) as $tutoria)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <small class="fw-bold">{{ $tutoria->tema }}</small>
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <span class="badge badge-custom {{ $tutoria->estado == 'activa' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($tutoria->estado) }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Estudiantes Page -->
                @if(request()->routeIs('coordinador.estudiantes'))
                <div id="estudiantes" class="page-section active">
                    <div class="page-header">
                        <h1 class="page-title">Gestión de Estudiantes</h1>
                        <p class="text-muted">Administrar información de estudiantes</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user-graduate me-2"></i>Lista de Estudiantes</span>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#crearEstudianteModal">
                                <i class="fas fa-plus me-1"></i> Nuevo Estudiante
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Carrera</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($estudiantes as $estudiante)
                                        <tr>
                                            <td>{{ $estudiante->id }}</td>
                                            <td>{{ $estudiante->name }}</td>
                                            <td>{{ $estudiante->email }}</td>
                                            <td>{{ $estudiante->carrera ?? 'No especificada' }}</td>
                                            <td>
                                                <span class="badge badge-custom {{ $estudiante->activo ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $estudiante->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom btn-ver-detalles-estudiante"
                                                        data-nombre="{{ $estudiante->name }}"
                                                        data-email="{{ $estudiante->email }}"
                                                        data-carrera="{{ $estudiante->carrera ?? 'No especificada' }}"
                                                        data-estado="{{ $estudiante->activo ? 'Activo' : 'Inactivo' }}">
                                                    Ver Detalles
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay estudiantes registrados</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Tutores Page -->
                @if(request()->routeIs('coordinador.tutores'))
                <div id="tutores" class="page-section active">
                    <div class="page-header">
                        <h1 class="page-title">Gestión de Tutores</h1>
                        <p class="text-muted">Administrar información de tutores</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users me-2"></i>Lista de Tutores</span>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#crearTutorModal">
                                <i class="fas fa-plus me-1"></i> Nuevo Tutor
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Especialidad</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tutores as $tutor)
                                        <tr>
                                            <td>{{ $tutor->id }}</td>
                                            <td>{{ $tutor->name }}</td>
                                            <td>{{ $tutor->email }}</td>
                                            <td>{{ $tutor->especialidad ?? 'No especificada' }}</td>
                                            <td>
                                                <span class="badge badge-custom {{ $tutor->activo ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $tutor->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom btn-ver-detalles-tutor"
                                                        data-nombre="{{ $tutor->name }}"
                                                        data-email="{{ $tutor->email }}"
                                                        data-especialidad="{{ $tutor->especialidad ?? 'No especificada' }}"
                                                        data-estado="{{ $tutor->activo ? 'Activo' : 'Inactivo' }}">
                                                    Ver Detalles
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay tutores registrados</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Reportes Page -->
                @if(request()->routeIs('coordinador.reportes'))
                <div id="reportes" class="page-section active">
                    <div class="page-header">
                        <h1 class="page-title">Reportes</h1>
                        <p class="text-muted">Generar y visualizar reportes del sistema</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-cog me-2"></i>Generar Reporte
                                </div>
                                <div class="card-body">
                                    <form id="form-generar-reporte" method="POST" action="{{ route('coordinador.reportes.generar') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="tipoReporte" class="form-label">Tipo de Reporte</label>
                                            <select class="form-select" id="tipoReporte" name="tipo" required>
                                                <option value="" selected>Seleccione un tipo...</option>
                                                <option value="asistencia">Reporte de Asistencia</option>
                                                <option value="tutorias">Reporte de Tutorías</option>
                                                <option value="estudiantes">Reporte de Estudiantes</option>
                                                <option value="tutores">Reporte de Tutores</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                                            <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechaFin" class="form-label">Fecha de Fin</label>
                                            <input type="date" class="form-control" id="fechaFin" name="fecha_fin" required>
                                        </div>
                                        <button type="submit" class="btn btn-custom w-100">
                                            <i class="fas fa-download me-1"></i> Generar Reporte
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-chart-line me-2"></i>Estadísticas del Sistema
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <div class="stats-card">
                                                <div class="stats-icon">
                                                    <i class="fas fa-chalkboard-teacher"></i>
                                                </div>
                                                <div class="stats-number">{{ $tutoriasActivas }}</div>
                                                <div class="stats-label">Tutorías Activas</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="stats-card">
                                                <div class="stats-icon">
                                                    <i class="fas fa-user-graduate"></i>
                                                </div>
                                                <div class="stats-number">{{ $totalEstudiantes }}</div>
                                                <div class="stats-label">Estudiantes</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="stats-card">
                                                <div class="stats-icon">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                                <div class="stats-number">{{ $totalTutores }}</div>
                                                <div class="stats-label">Tutores</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="stats-card">
                                                <div class="stats-icon">
                                                    <i class="fas fa-percentage"></i>
                                                </div>
                                                <div class="stats-number">{{ $asistenciaPromedio }}%</div>
                                                <div class="stats-label">Asistencia Promedio</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Resumen de Tutorías por Estado -->
                                    <div class="mt-4">
                                        <h6 class="fw-bold">Resumen de Tutorías por Estado</h6>
                                        @php
                                            $tutoriasActivasCount = App\Models\Tutoria::where('estado', 'activa')->count();
                                            $tutoriasPendientesCount = App\Models\Tutoria::where('estado', 'pendiente')->count();
                                            $tutoriasCanceladasCount = App\Models\Tutoria::where('estado', 'cancelada')->count();
                                            $totalTutorias = $tutoriasActivasCount + $tutoriasPendientesCount + $tutoriasCanceladasCount;
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between">
                                                    <span>Activas:</span>
                                                    <span class="fw-bold text-success">{{ $tutoriasActivasCount }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between">
                                                    <span>Pendientes:</span>
                                                    <span class="fw-bold text-warning">{{ $tutoriasPendientesCount }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between">
                                                    <span>Canceladas:</span>
                                                    <span class="fw-bold text-danger">{{ $tutoriasCanceladasCount }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Adicional -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-2"></i>Información de Reportes
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Tipos de Reportes Disponibles:</h6>
                                            <ul class="small">
                                                <li><strong>Asistencia:</strong> Detalle de asistencia por tutoría</li>
                                                <li><strong>Tutorías:</strong> Información de todas las tutorías</li>
                                                <li><strong>Estudiantes:</strong> Listado y estadísticas de estudiantes</li>
                                                <li><strong>Tutores:</strong> Información de tutores y sus tutorías</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Instrucciones:</h6>
                                            <ul class="small">
                                                <li>Seleccione el tipo de reporte deseado</li>
                                                <li>Defina el rango de fechas para el reporte</li>
                                                <li>Haga clic en "Generar Reporte"</li>
                                                <li>El reporte se descargará en formato PDF</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div> <!-- Cierra el content-area -->
        </div> <!-- Cierra el main-content -->
    </div> <!-- Cierra el dashboard-container -->

    <!-- Modal para Crear Tutoría -->
    <div class="modal fade" id="crearTutoriaModal" tabindex="-1" aria-labelledby="crearTutoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTutoriaModalLabel">Crear Nueva Tutoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('coordinador.tutorias.crear') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tema" class="form-label">Nombre de la Tutoría</label>
                                <input type="text" class="form-control" id="tema" name="tema" placeholder="Ej: Matemáticas Avanzadas" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_tutor" class="form-label">Tutor Asignado</label>
                                <select class="form-select" id="id_tutor" name="id_tutor" required>
                                    <option value="" selected>Seleccione un tutor...</option>
                                    @foreach($tutores ?? [] as $tutor)
                                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hora_inicio" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modalidad" class="form-label">Modalidad</label>
                                <select class="form-select" id="modalidad" name="modalidad" required>
                                    <option value="" selected>Seleccione modalidad...</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="virtual">Virtual</option>
                                    <option value="mixta">Mixta</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="activa" selected>Activa</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Descripción</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Descripción de la tutoría..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Crear Tutoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Estudiante -->
    <div class="modal fade" id="crearEstudianteModal" tabindex="-1" aria-labelledby="crearEstudianteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearEstudianteModalLabel">Registrar Nuevo Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('coordinador.estudiantes.crear') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="carrera" class="form-label">Carrera</label>
                            <select class="form-select" id="carrera" name="carrera" required>
                                <option value="" selected>Seleccione una carrera...</option>
                                <option value="Ing. Sistemas">Ing. Sistemas</option>
                                <option value="Ing. Civil">Ing. Civil</option>
                                <option value="Ing. Industrial">Ing. Industrial</option>
                                <option value="Administración">Administración</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Registrar Estudiante</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Tutor -->
    <div class="modal fade" id="crearTutorModal" tabindex="-1" aria-labelledby="crearTutorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTutorModalLabel">Registrar Nuevo Tutor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('coordinador.tutores.crear') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <select class="form-select" id="especialidad" name="especialidad" required>
                                <option value="" selected>Seleccione una especialidad...</option>
                                <option value="Matemáticas">Matemáticas</option>
                                <option value="Programación">Programación</option>
                                <option value="Base de Datos">Base de Datos</option>
                                <option value="Estadística">Estadística</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom">Registrar Tutor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funcionalidad para ver detalles de tutoría
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-ver-detalles-tutoria')) {
                const tema = e.target.getAttribute('data-tema');
                const tutor = e.target.getAttribute('data-tutor');
                const fecha = e.target.getAttribute('data-fecha');
                const modalidad = e.target.getAttribute('data-modalidad');
                const estado = e.target.getAttribute('data-estado');
                const descripcion = e.target.getAttribute('data-descripcion');
                
                alert(`Detalles de la tutoría:\n\nNombre: ${tema}\nTutor: ${tutor}\nFecha: ${fecha}\nModalidad: ${modalidad}\nEstado: ${estado}\nDescripción: ${descripcion}`);
            }
        });

        // Funcionalidad para ver detalles de estudiante
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-ver-detalles-estudiante')) {
                const nombre = e.target.getAttribute('data-nombre');
                const email = e.target.getAttribute('data-email');
                const carrera = e.target.getAttribute('data-carrera');
                const estado = e.target.getAttribute('data-estado');
                
                alert(`Detalles del estudiante:\n\nNombre: ${nombre}\nEmail: ${email}\nCarrera: ${carrera}\nEstado: ${estado}`);
            }
        });

        // Funcionalidad para ver detalles de tutor
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-ver-detalles-tutor')) {
                const nombre = e.target.getAttribute('data-nombre');
                const email = e.target.getAttribute('data-email');
                const especialidad = e.target.getAttribute('data-especialidad');
                const estado = e.target.getAttribute('data-estado');
                
                alert(`Detalles del tutor:\n\nNombre: ${nombre}\nEmail: ${email}\nEspecialidad: ${especialidad}\nEstado: ${estado}`);
            }
        });

       // Funcionalidad para cargar estudiantes de una tutoría
document.getElementById('selectTutoria')?.addEventListener('change', function() {
    const tutoriaId = this.value;
    const tablaAsistenciaContainer = document.getElementById('tabla-asistencia-container');
    
    if (tutoriaId) {
        // Mostrar tabla de asistencia
        tablaAsistenciaContainer.style.display = 'block';
        
        // Cargar estudiantes para la tutoría seleccionada
        fetch(`/coordinador/tutorias/${tutoriaId}/estudiantes`)
            .then(response => response.json())
            .then(estudiantes => {
                const tablaAsistencia = document.getElementById('estudiantes-tutoria');
                tablaAsistencia.innerHTML = '';
                
                if (estudiantes.length === 0) {
                    tablaAsistencia.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No hay estudiantes registrados en el sistema
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                estudiantes.forEach(estudiante => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${estudiante.name}</td>
                        <td>${estudiante.email}</td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="asistencia-${estudiante.id}" id="presente-${estudiante.id}" value="1" checked>
                                <label class="form-check-label text-success" for="presente-${estudiante.id}">Presente</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="asistencia-${estudiante.id}" id="ausente-${estudiante.id}" value="0">
                                <label class="form-check-label text-danger" for="ausente-${estudiante.id}">Ausente</label>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="observaciones-${estudiante.id}" placeholder="Observaciones...">
                        </td>
                    `;
                    tablaAsistencia.appendChild(fila);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                const tablaAsistencia = document.getElementById('estudiantes-tutoria');
                tablaAsistencia.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            Error al cargar los estudiantes. Intente nuevamente.
                        </td>
                    </tr>
                `;
            });
    } else {
        // Ocultar tabla de asistencia
        tablaAsistenciaContainer.style.display = 'none';
    }
});

        // Funcionalidad para guardar asistencia
        document.getElementById('btn-guardar-asistencia')?.addEventListener('click', function() {
            const tutoriaId = document.getElementById('selectTutoria').value;
            
            if (!tutoriaId) {
                alert('Por favor, seleccione una tutoría primero');
                return;
            }
            
            const formData = new FormData();
            formData.append('tutoria_id', tutoriaId);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            // Recolectar datos de asistencia
            const estudiantesRows = document.querySelectorAll('#estudiantes-tutoria tr');
            estudiantesRows.forEach(row => {
                const estudianteId = row.querySelector('input[type="radio"]').name.split('-')[1];
                const asistio = row.querySelector('input[type="radio"]:checked').value;
                const observaciones = row.querySelector('input[type="text"]').value;
                
                formData.append(`estudiantes[${estudianteId}][asistio]`, asistio);
                formData.append(`estudiantes[${estudianteId}][observaciones]`, observaciones);
            });
            
            fetch('{{ route("coordinador.asistencia.registrar") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Asistencia guardada correctamente');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar la asistencia');
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
    </script>
</body>
</html>