<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tutoria;
use App\Models\Asistencia;
use App\Models\Solicitud;
use App\Models\Material;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoordinadorController extends Controller
{
    public function dashboard()
    {
        $coordinador = Auth::user();
        
        // Estadísticas generales
        $tutoriasActivas = Tutoria::where('estado', 'activa')->count();
        $totalEstudiantes = User::where('role', 'estudiante')->count();
        $totalTutores = User::where('role', 'tutor')->count();
        
        // Calcular asistencia promedio
        $totalAsistencias = Asistencia::count();
        $asistenciasPresente = Asistencia::where('asistio', true)->count();
        $asistenciaPromedio = $totalAsistencias > 0 ? 
            round(($asistenciasPresente / $totalAsistencias) * 100) : 0;
        
        // Próximas tutorías
        $proximasTutorias = Tutoria::with('tutor')
            ->where('fecha', '>=', Carbon::now())
            ->whereIn('estado', ['activa', 'pendiente'])
            ->orderBy('fecha', 'asc')
            ->limit(5)
            ->get();
        
        // Solicitudes pendientes
        $solicitudesPendientes = Solicitud::where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('coordinador', compact(
            'coordinador',
            'tutoriasActivas',
            'totalEstudiantes',
            'totalTutores',
            'asistenciaPromedio',
            'proximasTutorias',
            'solicitudesPendientes'
        ));
    }

    public function gestionTutorias()
    {
        $coordinador = Auth::user();
        $tutorias = Tutoria::with(['tutor', 'estudiante'])
            ->orderBy('fecha', 'desc')
            ->get();
            
        $tutores = User::where('role', 'tutor')->get();

        return view('coordinador', compact('coordinador', 'tutorias', 'tutores'));
    }

    public function crearTutoria(Request $request)
    {
        $request->validate([
            'tema' => 'required|string|max:255',
            'id_tutor' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'modalidad' => 'required|in:presencial,virtual,mixta',
            'estado' => 'required|in:activa,pendiente,cancelada'
        ]);

        try {
            Tutoria::create([
                'tema' => $request->tema,
                'id_tutor' => $request->id_tutor,
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'modalidad' => $request->modalidad,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
                'cupo_maximo' => $request->cupo_maximo ?? 10
            ]);

            return redirect()->back()->with('success', 'Tutoría creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la tutoría: ' . $e->getMessage());
        }
    }

    public function actualizarTutoria(Request $request, $id)
    {
        $request->validate([
            'tema' => 'required|string|max:255',
            'id_tutor' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'modalidad' => 'required|in:presencial,virtual,mixta',
            'estado' => 'required|in:activa,pendiente,cancelada'
        ]);

        try {
            $tutoria = Tutoria::findOrFail($id);
            $tutoria->update($request->all());

            return redirect()->back()->with('success', 'Tutoría actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la tutoría: ' . $e->getMessage());
        }
    }

    public function eliminarTutoria($id)
    {
        try {
            $tutoria = Tutoria::findOrFail($id);
            $tutoria->delete();

            return redirect()->back()->with('success', 'Tutoría eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la tutoría: ' . $e->getMessage());
        }
    }

    public function gestionEstudiantes()
    {
        $coordinador = Auth::user();
        $estudiantes = User::where('role', 'estudiante')->get();

        return view('coordinador', compact('coordinador', 'estudiantes'));
    }

    public function crearEstudiante(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'carrera' => 'required|string'
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'estudiante',
                'carrera' => $request->carrera
            ]);

            return redirect()->back()->with('success', 'Estudiante creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el estudiante: ' . $e->getMessage());
        }
    }

    public function gestionTutores()
    {
        $coordinador = Auth::user();
        $tutores = User::where('role', 'tutor')->get();

        return view('coordinador', compact('coordinador', 'tutores'));
    }

    public function crearTutor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'especialidad' => 'required|string'
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'tutor',
                'especialidad' => $request->especialidad
            ]);

            return redirect()->back()->with('success', 'Tutor creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el tutor: ' . $e->getMessage());
        }
    }

    public function controlAsistencia()
    {
        $coordinador = Auth::user();
        $tutorias = Tutoria::where('fecha', '>=', Carbon::now()->subDays(30))
            ->with(['tutor', 'asistencias.estudiante'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('coordinador', compact('coordinador', 'tutorias'));
    }

    public function registrarAsistencia(Request $request)
    {
        try {
            $tutoriaId = $request->tutoria_id;
            $estudiantesData = $request->estudiantes;
            
            foreach ($estudiantesData as $estudianteId => $data) {
                Asistencia::updateOrCreate(
                    [
                        'id_tutoria' => $tutoriaId,
                        'id_estudiante' => $estudianteId
                    ],
                    [
                        'asistio' => $data['asistio'],
                        'observaciones' => $data['observaciones'] ?? null
                    ]
                );
            }
            
            return response()->json(['success' => true, 'message' => 'Asistencia registrada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al registrar asistencia: ' . $e->getMessage()]);
        }
    }

    public function generarReportes(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:asistencia,tutorias,estudiantes,tutores',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        // Lógica para generar reportes según el tipo
        $datos = $this->obtenerDatosReporte($request->tipo, $request->fecha_inicio, $request->fecha_fin);

        return response()->json([
            'success' => true,
            'datos' => $datos,
            'message' => 'Reporte generado exitosamente.'
        ]);
    }

    private function obtenerDatosReporte($tipo, $fechaInicio, $fechaFin)
    {
        switch ($tipo) {
            case 'asistencia':
                return $this->reporteAsistencia($fechaInicio, $fechaFin);
            case 'tutorias':
                return $this->reporteTutorias($fechaInicio, $fechaFin);
            case 'estudiantes':
                return $this->reporteEstudiantes($fechaInicio, $fechaFin);
            case 'tutores':
                return $this->reporteTutores($fechaInicio, $fechaFin);
        }
    }

    private function reporteAsistencia($fechaInicio, $fechaFin)
    {
        return Asistencia::with(['tutoria', 'estudiante'])
            ->whereHas('tutoria', function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            })
            ->get()
            ->groupBy('id_tutoria')
            ->map(function($asistencias) {
                $tutoria = $asistencias->first()->tutoria;
                return [
                    'tutoria' => $tutoria->tema,
                    'fecha' => $tutoria->fecha,
                    'total_estudiantes' => $asistencias->count(),
                    'presentes' => $asistencias->where('asistio', true)->count(),
                    'ausentes' => $asistencias->where('asistio', false)->count(),
                    'porcentaje_asistencia' => $asistencias->count() > 0 ? 
                        round(($asistencias->where('asistio', true)->count() / $asistencias->count()) * 100) : 0
                ];
            })->values();
    }

    private function reporteTutorias($fechaInicio, $fechaFin)
    {
        return Tutoria::with(['tutor', 'estudiantes'])
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get()
            ->map(function($tutoria) {
                return [
                    'tema' => $tutoria->tema,
                    'tutor' => $tutoria->tutor->name,
                    'fecha' => $tutoria->fecha,
                    'modalidad' => $tutoria->modalidad,
                    'estado' => $tutoria->estado,
                    'estudiantes_inscritos' => $tutoria->estudiantes->count(),
                    'cupo_maximo' => $tutoria->cupo_maximo
                ];
            });
    }

    private function reporteEstudiantes($fechaInicio, $fechaFin)
    {
        return User::where('role', 'estudiante')
            ->withCount(['asistencias as asistencias_totales' => function($query) use ($fechaInicio, $fechaFin) {
                $query->whereHas('tutoria', function($q) use ($fechaInicio, $fechaFin) {
                    $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
                });
            }])
            ->withCount(['asistencias as asistencias_presentes' => function($query) use ($fechaInicio, $fechaFin) {
                $query->where('asistio', true)
                    ->whereHas('tutoria', function($q) use ($fechaInicio, $fechaFin) {
                        $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
                    });
            }])
            ->get()
            ->map(function($estudiante) {
                $porcentaje = $estudiante->asistencias_totales > 0 ? 
                    round(($estudiante->asistencias_presentes / $estudiante->asistencias_totales) * 100) : 0;
                
                return [
                    'nombre' => $estudiante->name,
                    'email' => $estudiante->email,
                    'carrera' => $estudiante->carrera,
                    'asistencias_totales' => $estudiante->asistencias_totales,
                    'asistencias_presentes' => $estudiante->asistencias_presentes,
                    'porcentaje_asistencia' => $porcentaje
                ];
            });
    }

    private function reporteTutores($fechaInicio, $fechaFin)
    {
        return User::where('role', 'tutor')
            ->withCount(['tutoriasComoTutor as tutorias_impartidas' => function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            }])
            ->with(['tutoriasComoTutor' => function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            }])
            ->get()
            ->map(function($tutor) {
                $estudiantesAtendidos = $tutor->tutoriasComoTutor->sum(function($tutoria) {
                    return $tutoria->estudiantes->count();
                });

                return [
                    'nombre' => $tutor->name,
                    'email' => $tutor->email,
                    'especialidad' => $tutor->especialidad,
                    'tutorias_impartidas' => $tutor->tutorias_impartidas,
                    'estudiantes_atendidos' => $estudiantesAtendidos
                ];
            });
    }

    public function obtenerEstudiantesTutoria($tutoriaId)
    {
        try {
            $estudiantes = User::where('role', 'estudiante')->get(['id', 'name', 'email']);
            return response()->json($estudiantes);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
    public function reportes()
{
    $coordinador = Auth::user();
    
    // Estadísticas para mostrar en reportes
    $tutoriasActivas = Tutoria::where('estado', 'activa')->count();
    $totalEstudiantes = User::where('role', 'estudiante')->count();
    $totalTutores = User::where('role', 'tutor')->count();
    
    // Calcular asistencia promedio
    $totalAsistencias = Asistencia::count();
    $asistenciasPresente = Asistencia::where('asistio', true)->count();
    $asistenciaPromedio = $totalAsistencias > 0 ? 
        round(($asistenciasPresente / $totalAsistencias) * 100) : 0;

    return view('coordinador', compact(
        'coordinador',
        'tutoriasActivas',
        'totalEstudiantes',
        'totalTutores',
        'asistenciaPromedio'
    ));
}
}