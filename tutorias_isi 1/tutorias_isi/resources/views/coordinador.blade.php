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
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-graduation-cap me-2"></i>Sistema de Tutorías</h3>
            </div>
            <div class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-page="dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="tutorias">
                            <i class="fas fa-chalkboard-teacher"></i> Gestión de Tutorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="asistencia">
                            <i class="fas fa-clipboard-check"></i> Control de Asistencia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="reportes">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="estudiantes">
                            <i class="fas fa-user-graduate"></i> Estudiantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="tutores">
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
                    <h4 class="mb-0" id="current-page-title">Dashboard</h4>
                </div>
                <div class="user-info">
                    <div class="user-avatar">JS</div>
                    <div>
                        <div class="fw-bold">Juan Sebastián</div>
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
                                <div class="stats-number">24</div>
                                <div class="stats-label">Tutorías Activas</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="stats-number">156</div>
                                <div class="stats-label">Estudiantes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stats-number">18</div>
                                <div class="stats-label">Tutores</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="stats-number">92%</div>
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
                                                <tr>
                                                    <td>Matemáticas Avanzadas</td>
                                                    <td>Dr. Carlos Rodríguez</td>
                                                    <td>15 Nov, 10:00 AM</td>
                                                    <td><span class="badge badge-custom badge-success">Programada</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Programación en Python</td>
                                                    <td>Ing. María González</td>
                                                    <td>16 Nov, 2:00 PM</td>
                                                    <td><span class="badge badge-custom badge-warning">Pendiente</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Base de Datos</td>
                                                    <td>Lic. Roberto Silva</td>
                                                    <td>17 Nov, 9:00 AM</td>
                                                    <td><span class="badge badge-custom badge-success">Programada</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-bell me-2"></i>Notificaciones Recientes
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Nueva solicitud de tutoría de Ana Martínez</p>
                                            <small class="text-muted">Hace 2 horas</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Recordatorio: Tutoría de Matemáticas mañana</p>
                                            <small class="text-muted">Hace 5 horas</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">Reporte de asistencia generado exitosamente</p>
                                            <small class="text-muted">Ayer</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tutorías Page -->
                <div id="tutorias" class="page-section">
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
                                        <tr>
                                            <td>T-001</td>
                                            <td>Matemáticas Avanzadas</td>
                                            <td>Dr. Carlos Rodríguez</td>
                                            <td>15/11/2025 10:00</td>
                                            <td>Presencial</td>
                                            <td><span class="badge badge-custom badge-success">Activa</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Cancelar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>T-002</td>
                                            <td>Programación en Python</td>
                                            <td>Ing. María González</td>
                                            <td>16/11/2025 14:00</td>
                                            <td>Virtual</td>
                                            <td><span class="badge badge-custom badge-warning">Pendiente</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Cancelar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>T-003</td>
                                            <td>Base de Datos</td>
                                            <td>Lic. Roberto Silva</td>
                                            <td>17/11/2025 09:00</td>
                                            <td>Mixta</td>
                                            <td><span class="badge badge-custom badge-success">Activa</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Cancelar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>T-004</td>
                                            <td>Estructuras de Datos</td>
                                            <td>Mg. Laura Fernández</td>
                                            <td>18/11/2025 11:00</td>
                                            <td>Presencial</td>
                                            <td><span class="badge badge-custom badge-danger">Cancelada</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Reactivar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Asistencia Page -->
                <div id="asistencia" class="page-section">
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
                                            <option selected>Seleccione una tutoría...</option>
                                            <option value="1">Matemáticas Avanzadas - 15/11/2025</option>
                                            <option value="2">Programación en Python - 16/11/2025</option>
                                            <option value="3">Base de Datos - 17/11/2025</option>
                                        </select>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Estudiante</th>
                                                    <th>Asistencia</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Ana Martínez</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="asistencia1" id="presente1" checked>
                                                            <label class="form-check-label" for="presente1">Presente</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="asistencia1" id="ausente1">
                                                            <label class="form-check-label" for="ausente1">Ausente</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Observaciones...">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Carlos López</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="asistencia2" id="presente2">
                                                            <label class="form-check-label" for="presente2">Presente</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="asistencia2" id="ausente2" checked>
                                                            <label class="form-check-label" for="ausente2">Ausente</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Observaciones...">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>María García</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="asistencia3" id="presente3" checked>
                                                            <label class="form-check-label" for="presente3">Presente</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="asistencia3" id="ausente3">
                                                            <label class="form-check-label" for="ausente3">Ausente</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Observaciones...">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-custom">
                                            <i class="fas fa-save me-1"></i> Guardar Asistencia
                                        </button>
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
                                    <div class="mb-4">
                                        <h3 class="text-primary">75%</h3>
                                        <p class="text-muted">Asistencia General</p>
                                    </div>
                                    <div class="d-flex justify-content-around mb-3">
                                        <div>
                                            <h5 class="text-success">18</h5>
                                            <small>Presentes</small>
                                        </div>
                                        <div>
                                            <h5 class="text-danger">6</h5>
                                            <small>Ausentes</small>
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-success" style="width: 75%"></div>
                                    </div>
                                    <small class="text-muted">Última tutoría: Matemáticas Avanzadas</small>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-history me-2"></i>Historial Reciente
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Programación Python</span>
                                            <span class="badge badge-custom badge-success">80%</span>
                                        </div>
                                        <small class="text-muted">14 Nov 2025</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Base de Datos</span>
                                            <span class="badge badge-custom badge-warning">65%</span>
                                        </div>
                                        <small class="text-muted">10 Nov 2025</small>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <span>Matemáticas</span>
                                            <span class="badge badge-custom badge-success">90%</span>
                                        </div>
                                        <small class="text-muted">7 Nov 2025</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reportes Page -->
                <div id="reportes" class="page-section">
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
                                    <form>
                                        <div class="mb-3">
                                            <label for="tipoReporte" class="form-label">Tipo de Reporte</label>
                                            <select class="form-select" id="tipoReporte">
                                                <option selected>Seleccione un tipo...</option>
                                                <option value="asistencia">Reporte de Asistencia</option>
                                                <option value="tutorias">Reporte de Tutorías</option>
                                                <option value="estudiantes">Reporte de Estudiantes</option>
                                                <option value="tutores">Reporte de Tutores</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                                            <input type="date" class="form-control" id="fechaInicio">
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechaFin" class="form-label">Fecha de Fin</label>
                                            <input type="date" class="form-control" id="fechaFin">
                                        </div>
                                        <div class="mb-3">
                                            <label for="formatoReporte" class="form-label">Formato</label>
                                            <select class="form-select" id="formatoReporte">
                                                <option value="pdf" selected>PDF</option>
                                                <option value="excel">Excel</option>
                                                <option value="html">HTML</option>
                                            </select>
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
                                    <i class="fas fa-file-alt me-2"></i>Reportes Recientes
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Tipo</th>
                                                    <th>Fecha</th>
                                                    <th>Formato</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Reporte_Asistencia_Noviembre</td>
                                                    <td>Asistencia</td>
                                                    <td>10/11/2025</td>
                                                    <td>PDF</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom me-1">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-custom">
                                                            <i class="fas fa-download"></i> Descargar
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Reporte_Tutorias_Octubre</td>
                                                    <td>Tutorías</td>
                                                    <td>01/11/2025</td>
                                                    <td>Excel</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom me-1">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-custom">
                                                            <i class="fas fa-download"></i> Descargar
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Reporte_Estudiantes_2025</td>
                                                    <td>Estudiantes</td>
                                                    <td>15/10/2025</td>
                                                    <td>PDF</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-custom me-1">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
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
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-line me-2"></i>Estadísticas de Uso
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <h4 class="text-primary">24</h4>
                                            <small class="text-muted">Tutorías este mes</small>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <h4 class="text-success">156</h4>
                                            <small class="text-muted">Estudiantes atendidos</small>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <h4 class="text-warning">18</h4>
                                            <small class="text-muted">Tutores activos</small>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <h4 class="text-info">92%</h4>
                                            <small class="text-muted">Satisfacción general</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Estudiantes Page -->
                <div id="estudiantes" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Gestión de Estudiantes</h1>
                        <p class="text-muted">Administrar información de estudiantes</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user-graduate me-2"></i>Lista de Estudiantes</span>
                            <button class="btn btn-custom">
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
                                            <th>Tutorías Asistidas</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>E-001</td>
                                            <td>Ana Martínez</td>
                                            <td>ana.martinez@est.univalle.edu</td>
                                            <td>Ing. Sistemas</td>
                                            <td>12</td>
                                            <td><span class="badge badge-custom badge-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>E-002</td>
                                            <td>Carlos López</td>
                                            <td>carlos.lopez@est.univalle.edu</td>
                                            <td>Ing. Sistemas</td>
                                            <td>8</td>
                                            <td><span class="badge badge-custom badge-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>E-003</td>
                                            <td>María García</td>
                                            <td>maria.garcia@est.univalle.edu</td>
                                            <td>Ing. Sistemas</td>
                                            <td>15</td>
                                            <td><span class="badge badge-custom badge-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tutores Page -->
                <div id="tutores" class="page-section">
                    <div class="page-header">
                        <h1 class="page-title">Gestión de Tutores</h1>
                        <p class="text-muted">Administrar información de tutores</p>
                    </div>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users me-2"></i>Lista de Tutores</span>
                            <button class="btn btn-custom">
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
                                            <th>Tutorías Impartidas</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>T-001</td>
                                            <td>Dr. Carlos Rodríguez</td>
                                            <td>c.rodriguez@univalle.edu</td>
                                            <td>Matemáticas</td>
                                            <td>24</td>
                                            <td><span class="badge badge-custom badge-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>T-002</td>
                                            <td>Ing. María González</td>
                                            <td>m.gonzalez@univalle.edu</td>
                                            <td>Programación</td>
                                            <td>18</td>
                                            <td><span class="badge badge-custom badge-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>T-003</td>
                                            <td>Lic. Roberto Silva</td>
                                            <td>r.silva@univalle.edu</td>
                                            <td>Base de Datos</td>
                                            <td>15</td>
                                            <td><span class="badge badge-custom badge-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-custom me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-custom">Ver Detalles</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Tutoría -->
    <div class="modal fade" id="crearTutoriaModal" tabindex="-1" aria-labelledby="crearTutoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTutoriaModalLabel">Crear Nueva Tutoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombreTutoria" class="form-label">Nombre de la Tutoría</label>
                                <input type="text" class="form-control" id="nombreTutoria" placeholder="Ej: Matemáticas Avanzadas">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tutorAsignado" class="form-label">Tutor Asignado</label>
                                <select class="form-select" id="tutorAsignado">
                                    <option selected>Seleccione un tutor...</option>
                                    <option value="1">Dr. Carlos Rodríguez</option>
                                    <option value="2">Ing. María González</option>
                                    <option value="3">Lic. Roberto Silva</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fechaTutoria" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fechaTutoria">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="horaTutoria" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="horaTutoria">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modalidadTutoria" class="form-label">Modalidad</label>
                                <select class="form-select" id="modalidadTutoria">
                                    <option selected>Seleccione modalidad...</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="virtual">Virtual</option>
                                    <option value="mixta">Mixta</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estadoTutoria" class="form-label">Estado</label>
                                <select class="form-select" id="estadoTutoria">
                                    <option value="activa" selected>Activa</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionTutoria" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionTutoria" rows="3" placeholder="Descripción de la tutoría..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-custom">Crear Tutoría</button>
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
        
        // Simular funcionalidad de guardar asistencia
        document.querySelectorAll('.btn-custom').forEach(button => {
            if (button.textContent.includes('Guardar Asistencia')) {
                button.addEventListener('click', function() {
                    alert('Asistencia guardada correctamente');
                });
            }
        });
        
        // Simular funcionalidad de generar reporte
        document.querySelectorAll('.btn-custom').forEach(button => {
            if (button.textContent.includes('Generar Reporte')) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Reporte generado correctamente. Se descargará en breve.');
                });
            }
        });
    </script>
</body>
</html>