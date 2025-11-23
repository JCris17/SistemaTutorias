<?php

namespace App\Http\Controllers;

use App\Models\Tutoria;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\Material;
use App\Models\Tarea;
use App\Models\Notificacion;
use App\Models\Evaluacion;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstudianteController extends Controller
{
  public function dashboard()
    {
        $estudiante = Auth::user();
        $seccion = 'dashboard';
        
        if (!$estudiante) {
            return redirect()->route('landingpage')->with('error', 'Debes iniciar sesión.');
        }
        
        // Tutorías inscritas esta semana - CONSULTA CORREGIDA
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();
        
        $tutorias_inscritas_count = DB::table('tutoria_estudiante')
            ->join('tutorias', 'tutoria_estudiante.tutoria_id', '=', 'tutorias.id')
            ->where('tutoria_estudiante.estudiante_id', $estudiante->id)
            ->whereBetween('tutorias.fecha', [$inicioSemana, $finSemana])
            ->whereIn('tutoria_estudiante.estado', ['pendiente', 'confirmada'])
            ->count();
            
        // Próximas tutorías - CONSULTA CORREGIDA
        $proximas_tutorias = DB::table('tutoria_estudiante')
            ->join('tutorias', 'tutoria_estudiante.tutoria_id', '=', 'tutorias.id')
            ->join('users', 'tutorias.id_tutor', '=', 'users.id')
            ->where('tutoria_estudiante.estudiante_id', $estudiante->id)
            ->whereIn('tutoria_estudiante.estado', ['pendiente', 'confirmada'])
            ->where('tutorias.fecha', '>=', Carbon::now())
            ->select(
                'tutorias.*',
                'users.name as tutor_name',
                'tutoria_estudiante.estado as estado_inscripcion'
            )
            ->orderBy('tutorias.fecha', 'asc')
            ->limit(5)
            ->get();

        // Para mostrar en "Mis Próximas Tutorías" del dashboard
        $tutorias_inscritas = DB::table('tutoria_estudiante')
            ->join('tutorias', 'tutoria_estudiante.tutoria_id', '=', 'tutorias.id')
            ->join('users', 'tutorias.id_tutor', '=', 'users.id')
            ->where('tutoria_estudiante.estudiante_id', $estudiante->id)
            ->whereIn('tutoria_estudiante.estado', ['pendiente', 'confirmada'])
            ->select(
                'tutorias.*',
                'users.name as tutor_name',
                'tutoria_estudiante.estado as estado_inscripcion'
            )
            ->orderBy('tutorias.fecha', 'asc')
            ->get();

        // Resto de las consultas (asistencias, evaluaciones, etc.)
        $total_asistencias = Asistencia::where('id_estudiante', $estudiante->id)->count();
        $asistencias_presente = Asistencia::where('id_estudiante', $estudiante->id)
            ->where('asistio', true)
            ->count();
            
        $porcentaje_asistencia = $total_asistencias > 0 ? 
            round(($asistencias_presente / $total_asistencias) * 100) : 0;
            
        $evaluaciones = Evaluacion::where('id_estudiante', $estudiante->id)->get();
        $promedio_general = $evaluaciones->count() > 0 ? 
            round($evaluaciones->avg('calificacion'), 1) : 0;
            
        $tareas_pendientes_count = Tarea::where('id_estudiante', $estudiante->id)
            ->where('completada', false)
            ->count();
                
        $notificaciones = Notificacion::where('id_estudiante', $estudiante->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        $tareas_pendientes = Tarea::where('id_estudiante', $estudiante->id)
            ->where('completada', false)
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        return view('estudiante', compact(
            'tutorias_inscritas_count',
            'porcentaje_asistencia',
            'promedio_general',
            'tareas_pendientes_count',
            'proximas_tutorias',
            'tutorias_inscritas', // AÑADIDO
            'notificaciones',
            'tareas_pendientes',
            'asistencias_presente',
            'total_asistencias',
            'estudiante',
            'seccion'
        ));
    }

    public function misTutorias()
    {
        $estudiante = Auth::user();
        $seccion = 'mistutorias'; // CORREGIDO: debe coincidir con el data-page del HTML
        
        // Tutorías inscritas - CONSULTA CORREGIDA
        $tutorias_inscritas = DB::table('tutoria_estudiante')
            ->join('tutorias', 'tutoria_estudiante.tutoria_id', '=', 'tutorias.id')
            ->join('users', 'tutorias.id_tutor', '=', 'users.id')
            ->where('tutoria_estudiante.estudiante_id', $estudiante->id)
            ->whereIn('tutoria_estudiante.estado', ['pendiente', 'confirmada'])
            ->select(
                'tutorias.*',
                'users.name as tutor_name',
                'tutoria_estudiante.estado as estado_inscripcion'
            )
            ->orderBy('tutorias.fecha', 'asc')
            ->get();
            
        // Historial de tutorías completadas
        $historial_tutorias = DB::table('tutoria_estudiante')
            ->join('tutorias', 'tutoria_estudiante.tutoria_id', '=', 'tutorias.id')
            ->join('users', 'tutorias.id_tutor', '=', 'users.id')
            ->where('tutoria_estudiante.estudiante_id', $estudiante->id)
            ->where('tutoria_estudiante.estado', 'completada')
            ->select(
                'tutorias.*',
                'users.name as tutor_name',
                'tutoria_estudiante.estado as estado_inscripcion'
            )
            ->orderBy('tutorias.fecha', 'desc')
            ->get();

        return view('estudiante', compact(
            'estudiante',
            'tutorias_inscritas',
            'historial_tutorias',
            'seccion'
        ));
    }

    public function inscribirse(Request $request)
    {
        $estudiante = Auth::user();
        $seccion = 'inscribirse';
        
        // Tutorías disponibles - CONSULTA MEJORADA
        $tutorias_disponibles = Tutoria::where('fecha', '>=', Carbon::now())
            ->where(function($query) {
                $query->where('estado', 'activa')
                      ->orWhere('estado', 'pendiente');
            });
            
        // Aplicar filtros
        if ($request->has('materia') && $request->materia) {
            $tutorias_disponibles->where('tema', 'like', '%' . $request->materia . '%');
        }
        
        if ($request->has('tutor') && $request->tutor) {
            $tutorias_disponibles->where('id_tutor', $request->tutor);
        }
        
        $tutorias_disponibles = $tutorias_disponibles->with('tutor')->get();
        
        // Excluir tutorías en las que ya está inscrito
        $tutorias_inscritas_ids = DB::table('tutoria_estudiante')
            ->where('estudiante_id', $estudiante->id)
            ->pluck('tutoria_id')
            ->toArray();
            
        $tutorias_disponibles = $tutorias_disponibles->filter(function($tutoria) use ($tutorias_inscritas_ids) {
            return !in_array($tutoria->id, $tutorias_inscritas_ids);
        });
        
        // Datos para filtros
        $materias = Tutoria::whereNotNull('tema')->distinct()->pluck('tema');
        $tutores = User::where('role', 'tutor')->get();

        return view('estudiante', compact(
            'estudiante',
            'tutorias_disponibles',
            'materias',
            'tutores',
            'seccion'
        ));
    }

    public function inscribirTutoria(Request $request, $tutoriaId)
    {
        $estudiante = Auth::user();
        
        try {
            \Log::info('Intentando inscribir tutoría:', [
                'estudiante_id' => $estudiante->id,
                'tutoria_id' => $tutoriaId
            ]);

            // Verificar que la tutoría existe
            $tutoria = Tutoria::where('id', $tutoriaId)->first();

            if (!$tutoria) {
                \Log::error('Tutoría no encontrada:', ['tutoria_id' => $tutoriaId]);
                return redirect()->route('estudiante.inscribirse')->with('error', 'La tutoría no existe.');
            }

            // Verificar que no está ya inscrito
            $yaInscrito = DB::table('tutoria_estudiante')
                            ->where('tutoria_id', $tutoriaId)
                            ->where('estudiante_id', $estudiante->id)
                            ->exists();

            if ($yaInscrito) {
                return redirect()->route('estudiante.inscribirse')->with('error', 'Ya estás inscrito en esta tutoría.');
            }

            // Verificaciones adicionales
            if ($tutoria->estado != 'activa' && $tutoria->estado != 'pendiente') {
                return redirect()->route('estudiante.inscribirse')->with('error', 'Esta tutoría no está disponible para inscripción.');
            }

            if ($tutoria->fecha < now()) {
                return redirect()->route('estudiante.inscribirse')->with('error', 'Esta tutoría ya ha pasado.');
            }

            // Inscribir al estudiante
            DB::table('tutoria_estudiante')->insert([
                'tutoria_id' => $tutoriaId,
                'estudiante_id' => $estudiante->id,
                'estado' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \Log::info('Inscripción exitosa:', [
                'estudiante_id' => $estudiante->id,
                'tutoria_id' => $tutoriaId
            ]);

            return redirect()->route('estudiante.inscribirse')->with('success', 'Te has inscrito correctamente en la tutoría.');

        } catch (\Exception $e) {
            \Log::error('Error al inscribir tutoría: ' . $e->getMessage(), [
                'estudiante_id' => $estudiante->id,
                'tutoria_id' => $tutoriaId,
                'error' => $e->getTraceAsString()
            ]);
            return redirect()->route('estudiante.inscribirse')->with('error', 'No se pudo completar la inscripción: ' . $e->getMessage());
        }
    }

    // AÑADIR MÉTODO PARA CANCELAR TUTORÍA
    public function cancelarTutoria($tutoriaId)
    {
        $estudiante = Auth::user();
        
        try {
            DB::table('tutoria_estudiante')
                ->where('tutoria_id', $tutoriaId)
                ->where('estudiante_id', $estudiante->id)
                ->delete();

            return redirect()->route('estudiante.tutorias')->with('success', 'Tutoría cancelada correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('estudiante.tutorias')->with('error', 'No se pudo cancelar la tutoría: ' . $e->getMessage());
        }
    }
    public function progreso()
    {
        $estudiante = Auth::user();
        $seccion = 'progreso';
        // Datos de progreso
        $total_tutorias_completadas = Tutoria::where('id_estudiante', $estudiante->id)
            ->where('estado', 'completada')
            ->count();
            
        $asistencias_presente = Asistencia::where('id_estudiante', $estudiante->id)
            ->where('asistio', true)
            ->count();
            
        $asistencias_ausente = Asistencia::where('id_estudiante', $estudiante->id)
            ->where('asistio', false)
            ->count();
            
        $total_asistencias = $asistencias_presente + $asistencias_ausente;
        $porcentaje_asistencia = $total_asistencias > 0 ? 
            round(($asistencias_presente / $total_asistencias) * 100) : 0;
            
        // Promedio por materia
        $evaluaciones = Evaluacion::where('id_estudiante', $estudiante->id)->get();
        $rendimiento_materias = [];
        
        foreach ($evaluaciones->groupBy('materia') as $materia => $evalMateria) {
            $rendimiento_materias[$materia] = [
                'promedio' => round($evalMateria->avg('calificacion'), 1),
                'cantidad' => $evalMateria->count()
            ];
        }
        
        // Evaluaciones
        $evaluaciones_lista = Evaluacion::where('id_estudiante', $estudiante->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Logros (simulados por ahora)
        $logros = [
            [
                'icono' => 'medal',
                'color' => 'warning',
                'titulo' => 'Asistencia Perfecta',
                'descripcion' => 'Asististe a 10 tutorías consecutivas'
            ],
            [
                'icono' => 'star',
                'color' => 'info',
                'titulo' => 'Excelente Rendimiento',
                'descripcion' => 'Promedio mayor a 8.5 en Matemáticas'
            ]
        ];

        // CAMBIO: Usar vista 'estudiante'
        return view('estudiante', compact(
            'estudiante',
            'total_tutorias_completadas',
            'asistencias_presente',
            'asistencias_ausente',
            'total_asistencias',
            'porcentaje_asistencia',
            'rendimiento_materias',
            'evaluaciones_lista',
            'logros',
            'seccion'
        ));
    }

    public function recursos()
    {
        $estudiante = Auth::user();
        
        // Materiales por materia
        $materiales_por_materia = Material::select('materia')
            ->selectRaw('COUNT(*) as cantidad')
            ->groupBy('materia')
            ->get()
            ->mapWithKeys(function($item) {
                $iconos = [
                    'Matemáticas' => ['icono' => 'calculator', 'color' => 'primary'],
                    'Programación' => ['icono' => 'code', 'color' => 'success'],
                    'Base de Datos' => ['icono' => 'database', 'color' => 'warning'],
                    'Estadística' => ['icono' => 'chart-bar', 'color' => 'info']
                ];
                
                return [
                    $item->materia => array_merge(
                        ['cantidad' => $item->cantidad],
                        $iconos[$item->materia] ?? ['icono' => 'file', 'color' => 'secondary']
                    )
                ];
            });
            
        // Materiales recientes
        $materiales_recientes = Material::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Enlaces útiles
        $enlaces_utiles = [
            ['nombre' => 'Khan Academy - Matemáticas', 'url' => 'https://www.khanacademy.org/math'],
            ['nombre' => 'W3Schools - Programación', 'url' => 'https://www.w3schools.com/python/'],
            ['nombre' => 'SQLZoo - Práctica de SQL', 'url' => 'https://sqlzoo.net/']
        ];

        // CAMBIO: Usar vista 'estudiante'
        return view('estudiante', compact(
            'estudiante',
            'materiales_por_materia',
            'materiales_recientes',
            'enlaces_utiles'
        ));
    }

    public function solicitudes()
    {
        $estudiante = Auth::user();
        
        // Solicitudes recientes
        $solicitudes_recientes = Solicitud::where('id_estudiante', $estudiante->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Datos para el formulario
        $materias = Tutoria::distinct()->pluck('materia');
        $tutores = User::where('rol', 'tutor')->get();

        // CAMBIO: Usar vista 'estudiante'
        return view('estudiante', compact(
            'estudiante',
            'solicitudes_recientes',
            'materias',
            'tutores'
        ));
    }

    // ... los demás métodos (inscribirTutoria, cancelarTutoria, crearSolicitud) se mantienen igual
}