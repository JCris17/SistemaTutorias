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
        
        // Tutorías inscritas esta semana
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();
        
        $tutorias_inscritas_count = DB::table('tutoria_estudiante')
            ->join('tutorias', 'tutoria_estudiante.tutoria_id', '=', 'tutorias.id')
            ->where('tutoria_estudiante.estudiante_id', $estudiante->id)
            ->whereBetween('tutorias.fecha', [$inicioSemana, $finSemana])
            ->whereIn('tutoria_estudiante.estado', ['pendiente', 'confirmada'])
            ->count();
            
        // Próximas tutorías
        $proximas_tutorias = DB::table('tutoria_estudiante')
            ->join('tutorias', 'tutoria_estudiante.tutoria_id', '=', 'tutorias.id')
            ->join('users', 'tutorias.id_tutor', '=', 'users.id')
            ->where('tutoria_estudiante.estudiante_id', $estudiante->id)
            ->whereIn('tutoria_estudiante.estado', ['pendiente', 'confirmada'])
            ->where('tutorias.fecha', '>=', Carbon::now()->format('Y-m-d'))
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

        // Asistencias
        $total_asistencias = Asistencia::where('id_estudiante', $estudiante->id)->count();
        $asistencias_presente = Asistencia::where('id_estudiante', $estudiante->id)
            ->where('asistio', true)
            ->count();
            
        $porcentaje_asistencia = $total_asistencias > 0 ? 
            round(($asistencias_presente / $total_asistencias) * 100) : 0;
            
        // Evaluaciones
        $evaluaciones = Evaluacion::where('id_estudiante', $estudiante->id)->get();
        $promedio_general = $evaluaciones->count() > 0 ? 
            round($evaluaciones->avg('calificacion'), 1) : 0;
            
        // Tareas pendientes
        $tareas_pendientes_count = Tarea::where('id_estudiante', $estudiante->id)
            ->where('completada', false)
            ->count();
                
        // Notificaciones
        $notificaciones = Notificacion::where('id_estudiante', $estudiante->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        // Tareas pendientes
        $tareas_pendientes = Tarea::where('id_estudiante', $estudiante->id)
            ->where('completada', false)
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        // Materias para filtros
        $materias = Tutoria::whereNotNull('tema')->distinct()->pluck('tema');
        $tutores = User::where('role', 'tutor')->get();

        return view('estudiante', compact(
            'tutorias_inscritas_count',
            'porcentaje_asistencia',
            'promedio_general',
            'tareas_pendientes_count',
            'proximas_tutorias',
            'tutorias_inscritas',
            'notificaciones',
            'tareas_pendientes',
            'asistencias_presente',
            'total_asistencias',
            'estudiante',
            'seccion',
            'materias',
            'tutores'
        ));
    }

    public function misTutorias()
    {
        $estudiante = Auth::user();
        $seccion = 'mistutorias';
        
        // Tutorías inscritas
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
    
    // Obtener IDs de tutorías en las que ya está inscrito
    $tutorias_inscritas_ids = DB::table('tutoria_estudiante')
        ->where('estudiante_id', $estudiante->id)
        ->pluck('tutoria_id')
        ->toArray();
    
    // Tutorías disponibles (excluyendo las ya inscritas)
    $tutorias_disponibles = Tutoria::where('fecha', '>=', Carbon::now()->format('Y-m-d'))
        ->where(function($query) {
            $query->where('estado', 'activa')
                  ->orWhere('estado', 'pendiente');
        })
        ->whereNotIn('id', $tutorias_inscritas_ids);
        
    // Aplicar filtros
    if ($request->has('materia') && $request->materia) {
        $tutorias_disponibles->where('tema', 'like', '%' . $request->materia . '%');
    }
    
    if ($request->has('tutor') && $request->tutor) {
        $tutorias_disponibles->where('id_tutor', $request->tutor);
    }
    
    $tutorias_disponibles = $tutorias_disponibles->with('tutor')->get();
    
    // Obtener tutorías inscritas para mostrar en el sidebar
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
    
    // Datos para filtros
    $materias = Tutoria::whereNotNull('tema')->distinct()->pluck('tema');
    $tutores = User::where('role', 'tutor')->get();

    return view('estudiante', compact(
        'estudiante',
        'tutorias_disponibles',
        'tutorias_inscritas',
        'tutorias_inscritas_ids', // Pasar también los IDs para la verificación
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

            if ($tutoria->fecha < now()->format('Y-m-d')) {
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
    $estudiante_id = Auth::id();
    
    // Obtener asistencias del estudiante
    $asistencias = DB::table('asistencias')
        ->where('id_estudiante', $estudiante_id)
        ->get();

    // Calcular estadísticas
    $total_asistencias = $asistencias->count();
    $asistencias_presente = $asistencias->where('asistio', 1)->count();
    $asistencias_ausente = $asistencias->where('asistio', 0)->count();
    
    $porcentaje_asistencia = $total_asistencias > 0 
        ? round(($asistencias_presente / $total_asistencias) * 100) 
        : 0;

    // Obtener evaluaciones para el promedio
    $evaluaciones = DB::table('evaluaciones')
        ->where('id_estudiante', $estudiante_id)
        ->get();

    $promedio_general = $evaluaciones->count() > 0 
        ? round($evaluaciones->avg('calificacion'), 1) 
        : 0;

    // Tutorías completadas (basado en asistencias)
    $total_tutorias_completadas = $asistencias_presente;

    // Rendimiento por materia - CALCULADO DESDE LA BASE DE DATOS
    $rendimiento_materias = DB::table('evaluaciones')
        ->where('id_estudiante', $estudiante_id)
        ->groupBy('materia')
        ->select('materia', DB::raw('ROUND(AVG(calificacion), 1) as promedio'))
        ->get()
        ->mapWithKeys(function ($item) {
            return [
                $item->materia => [
                    'promedio' => $item->promedio,
                    'color' => $this->getColorPorCalificacion($item->promedio)
                ]
            ];
        })
        ->toArray();

    // Si no hay evaluaciones, mostrar datos de ejemplo
    if (empty($rendimiento_materias)) {
        $rendimiento_materias = [
            'Base de Datos' => ['promedio' => 0, 'color' => 'secondary'],
            'Programación' => ['promedio' => 0, 'color' => 'secondary'],
            'Matemáticas' => ['promedio' => 0, 'color' => 'secondary'],
        ];
    }

    // Logros basados en el progreso
    $logros = [];
    if ($asistencias_presente >= 10) {
        $logros[] = [
            'titulo' => 'Asistencia Perfecta',
            'descripcion' => 'Asististe a 10 tutorías consecutivas',
            'icono' => 'award',
            'color' => 'success'
        ];
    }
    if ($promedio_general >= 8.5) {
        $logros[] = [
            'titulo' => 'Excelente Rendimiento',
            'descripcion' => 'Promedio mayor a 8.5 en evaluaciones',
            'icono' => 'star',
            'color' => 'warning'
        ];
    }
    if ($asistencias_presente >= 5 && $asistencias_presente < 10) {
        $logros[] = [
            'titulo' => 'Buen Asistente',
            'descripcion' => 'Asististe a 5 o más tutorías',
            'icono' => 'check-circle',
            'color' => 'info'
        ];
    }

    // Historial de evaluaciones - CONSULTA CORREGIDA (sin id_tutoria)
    $evaluaciones_lista = DB::table('evaluaciones')
        ->leftJoin('users', 'evaluaciones.id_tutor', '=', 'users.id')
        ->where('evaluaciones.id_estudiante', $estudiante_id)
        ->select(
            'evaluaciones.*', 
            'users.name as tutor_name'
        )
        ->orderBy('evaluaciones.fecha_evaluacion', 'desc')
        ->get();

    $seccion = 'progreso';

    return view('estudiante', compact(
        'porcentaje_asistencia',
        'promedio_general',
        'total_tutorias_completadas',
        'asistencias_presente',
        'asistencias_ausente',
        'total_asistencias',
        'rendimiento_materias',
        'logros',
        'evaluaciones_lista',
        'seccion'
    ));
}

// Añade este método auxiliar para determinar el color según la calificación
private function getColorPorCalificacion($calificacion)
{
    if ($calificacion >= 8) {
        return 'success';
    } elseif ($calificacion >= 6) {
        return 'warning';
    } else {
        return 'danger';
    }
}

   public function recursos()
{
    try {
        $seccion = 'recursos';
        
        // Consulta directa y simple
        $recursos = DB::table('recursos')->get();
        $materiales_recientes = $recursos;

        $enlaces_utiles = [
            ['nombre' => 'Khan Academy - Matemáticas', 'url' => 'https://www.khanacademy.org/math'],
            ['nombre' => 'Wolfram Alpha - Calculadora', 'url' => 'https://www.wolframalpha.com/'],
            ['nombre' => 'GeoGebra - Geometría Interactiva', 'url' => 'https://www.geogebra.org/'],
        ];

        return view('estudiante', compact(
            'recursos',
            'materiales_recientes',
            'enlaces_utiles',
            'seccion'
        ));
        
    } catch (\Exception $e) {
        // Si hay error, mostrar vacío
        return view('estudiante', [
            'recursos' => collect([]),
            'materiales_recientes' => collect([]),
            'enlaces_utiles' => [],
            'seccion' => 'recursos'
        ]);
    }
}
    private function getIconoPorMateria($materia)
    {
        $iconos = [
            'Base de Datos' => 'database',
            'Programación' => 'code',
            'Matemáticas' => 'calculator',
            'Inglés' => 'language',
        ];
        
        return $iconos[$materia] ?? 'file';
    }

private function getColorPorMateria($materia)
{
    $colores = [
        'Base de Datos' => 'primary',
        'Programación' => 'info',
        'Matemáticas' => 'success',
        'Inglés' => 'warning',
    ];
    
    return $colores[$materia] ?? 'secondary';
}
public function downloadRecurso($id)
{
    try {
        $recurso = DB::table('recursos')->where('id', $id)->first();
        
        if (!$recurso) {
            return redirect()->route('estudiante.recursos')->with('error', 'Recurso no encontrado.');
        }

        $filePath = $recurso->archivo;
        
        if (!$filePath) {
            return redirect()->route('estudiante.recursos')->with('error', 'Archivo no disponible.');
        }

        // Ruta CORRECTA basada en donde se guardan los archivos
        $fullPath = storage_path('app/private/public/recursos/' . $filePath);

        \Log::info('Buscando archivo en: ' . $fullPath);
        \Log::info('Archivo existe: ' . (file_exists($fullPath) ? 'SÍ' : 'NO'));

        if (!file_exists($fullPath)) {
            \Log::error('Archivo no encontrado en: ' . $fullPath);
            return redirect()->route('estudiante.recursos')->with('error', 'El archivo no existe en el servidor.');
        }

        // Obtener el nombre original del archivo
        $nombreArchivo = $recurso->nombre . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
        
        // Descargar el archivo
        return response()->download($fullPath, $nombreArchivo);

    } catch (\Exception $e) {
        \Log::error('Error al descargar recurso: ' . $e->getMessage());
        \Log::error('Trace: ' . $e->getTraceAsString());
        return redirect()->route('estudiante.recursos')->with('error', 'Error al descargar el recurso.');
    }
}
    public function solicitudes()
    {
        $estudiante = Auth::user();
        $seccion = 'solicitudes';
        
        // Solicitudes recientes
        $solicitudes_recientes = Solicitud::where('id_estudiante', $estudiante->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Datos para el formulario
        $materias = Tutoria::distinct()->pluck('tema');
        $tutores = User::where('role', 'tutor')->get();

        return view('estudiante', compact(
            'estudiante',
            'solicitudes_recientes',
            'materias',
            'tutores',
            'seccion'
        ));
    }

    public function crearSolicitud(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string',
            'materia' => 'required|string',
            'descripcion' => 'required|string',
            'urgencia' => 'required|string'
        ]);

        try {
            Solicitud::create([
                'id_estudiante' => Auth::id(),
                'tipo' => $request->tipo,
                'materia' => $request->materia,
                'id_tutor' => $request->id_tutor,
                'descripcion' => $request->descripcion,
                'urgencia' => $request->urgencia,
                'estado' => 'pendiente'
            ]);

            return redirect()->route('estudiante.solicitudes')->with('success', 'Tu solicitud ha sido enviada correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('estudiante.solicitudes')->with('error', 'Error al enviar la solicitud: ' . $e->getMessage());
        }
    }
}