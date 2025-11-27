<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Tutoria;
use App\Models\User;
use App\Models\Recurso;
use App\Models\Asistencia;

class TutorController extends Controller
{
  public function dashboard()
{
    $tutor_id = auth()->id();
    
    // Obtener tutorías programadas
    $tutorias_programadas = DB::table('tutorias')
        ->where('id_tutor', $tutor_id)
        ->where('fecha', '>=', now()->format('Y-m-d'))
        ->orderBy('fecha', 'asc')
        ->get();

    // Obtener tutorías pasadas
    $tutorias_pasadas = DB::table('tutorias')
        ->where('id_tutor', $tutor_id)
        ->where('fecha', '<', now()->format('Y-m-d'))
        ->orderBy('fecha', 'desc')
        ->get();

    // Obtener estudiantes
    $estudiantes = DB::table('users')
        ->where('role', 'estudiante')
        ->get();

    // Obtener recursos del tutor - ESTO ES CLAVE
    $recursos = DB::table('recursos')
        ->where('tutor_id', $tutor_id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Obtener solicitudes recientes - ESTO ES CLAVE
    $solicitudes_recientes = DB::table('solicitudes')
        ->join('users', 'solicitudes.id_estudiante', '=', 'users.id')
        ->where(function($query) use ($tutor_id) {
            $query->where('solicitudes.id_tutor', $tutor_id)
                  ->orWhereNull('solicitudes.id_tutor');
        })
        ->where('solicitudes.estado', 'pendiente')
        ->select('solicitudes.*', 'users.name as estudiante_nombre')
        ->orderBy('solicitudes.created_at', 'desc')
        ->limit(3)
        ->get();

    // Obtener asistencias recientes
    $asistencias_recientes = DB::table('asistencias')
        ->join('tutorias', 'asistencias.id_tutoria', '=', 'tutorias.id')
        ->where('tutorias.id_tutor', $tutor_id)
        ->select('asistencias.fecha_asistencia', 'tutorias.tema')
        ->selectRaw('COUNT(*) as total_estudiantes')
        ->selectRaw('SUM(asistencias.asistio) as presentes')
        ->groupBy('asistencias.fecha_asistencia', 'tutorias.tema')
        ->orderBy('asistencias.fecha_asistencia', 'desc')
        ->limit(5)
        ->get()
        ->map(function($item) {
            $item->porcentaje_asistencia = $item->total_estudiantes > 0 
                ? round(($item->presentes / $item->total_estudiantes) * 100) 
                : 0;
            return $item;
        });

    return view('tutor', compact(
        'tutorias_programadas', 
        'tutorias_pasadas',
        'estudiantes',
        'recursos', 
        'solicitudes_recientes', 
        'asistencias_recientes'
    ));
}
    public function registrarAsistencia(Request $request)
    {
        $request->validate([
            'tutoria_id' => 'required|exists:tutorias,id',
            'asistencias' => 'required|array'
        ]);

        $tutoria = DB::table('tutorias')->where('id', $request->tutoria_id)->first();
        
        foreach ($request->asistencias as $estudianteId => $asistenciaData) {
            // Verificar si ya existe una asistencia para esta tutoría y estudiante
            $existing = DB::table('asistencias')
                ->where('id_tutoria', $request->tutoria_id)
                ->where('id_estudiante', $estudianteId)
                ->first();

            if ($existing) {
                // Actualizar
                DB::table('asistencias')
                    ->where('id', $existing->id)
                    ->update([
                        'asistio' => $asistenciaData['asistio'],
                        'observaciones' => $asistenciaData['observaciones'] ?? null,
                        'updated_at' => now()
                    ]);
            } else {
                // Crear nueva
                DB::table('asistencias')->insert([
                    'id_tutoria' => $request->tutoria_id,
                    'id_estudiante' => $estudianteId,
                    'asistio' => $asistenciaData['asistio'],
                    'observaciones' => $asistenciaData['observaciones'] ?? null,
                    'fecha_asistencia' => $tutoria->fecha,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return back()->with('success', 'Asistencia registrada correctamente');
    }

    public function actualizarHorario(Request $request)
    {
        $request->validate([
            'dias' => 'required|array',
            'dias.*.dia' => 'required|string',
            'dias.*.hora_inicio' => 'required',
            'dias.*.hora_fin' => 'required'
        ]);

        $tutor_id = auth()->id();

        // Eliminar horarios existentes del tutor
        DB::table('horarios_tutor')->where('tutor_id', $tutor_id)->delete();

        // Crear nuevos horarios
        foreach ($request->dias as $dia) {
            DB::table('horarios_tutor')->insert([
                'tutor_id' => $tutor_id,
                'dia_semana' => $dia['dia'],
                'hora_inicio' => $dia['hora_inicio'],
                'hora_fin' => $dia['hora_fin'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'Horario actualizado correctamente');
    }

    public function estudiantes()
    {
        $tutor_id = auth()->id();
        
        $estudiantes = DB::table('users')
            ->where('role', 'estudiante')
            ->get()
            ->map(function($estudiante) use ($tutor_id) {
                // Obtener tutorías del estudiante con este tutor
                $tutorias_estudiante = DB::table('tutorias')
                    ->where('id_tutor', $tutor_id)
                    ->where('id_estudiante', $estudiante->id)
                    ->get();

                // Obtener asistencias del estudiante
                $asistencias = DB::table('asistencias')
                    ->where('id_estudiante', $estudiante->id)
                    ->whereIn('id_tutoria', $tutorias_estudiante->pluck('id'))
                    ->get();

                $total_asistencias = $asistencias->count();
                $presentes = $asistencias->where('asistio', 1)->count();
                
                $estudiante->porcentaje_asistencia = $total_asistencias > 0 
                    ? round(($presentes / $total_asistencias) * 100) 
                    : 0;

                $estudiante->ultima_tutoria = $tutorias_estudiante->sortByDesc('fecha')->first();

                return $estudiante;
            });

        return view('tutor.estudiantes', compact('estudiantes'));
    }

    public function subirRecurso(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|in:documento,presentacion,video,enlace',
        'descripcion' => 'nullable|string'
    ]);

    $recursoData = [
        'tutor_id' => auth()->id(),
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
        'descripcion' => $request->descripcion,
        'created_at' => now(),
        'updated_at' => now()
    ];

    if ($request->tipo === 'enlace') {
        $request->validate(['enlace' => 'required|url']);
        $recursoData['enlace'] = $request->enlace;
    } else {
        $request->validate(['archivo' => 'required|file|max:10240']);
        
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            
            // Guardar usando Storage
            $path = $archivo->storeAs('public/recursos', $nombreArchivo);
            $recursoData['archivo'] = $nombreArchivo;
            $recursoData['tamaño'] = $archivo->getSize();
            
            // Debug: verificar que el archivo se guardó
            \Log::info('Archivo guardado en: ' . $path);
        }
    }

    DB::table('recursos')->insert($recursoData);

    return back()->with('success', 'Recurso subido correctamente');
}
    public function downloadRecurso($id)
{
    $recurso = DB::table('recursos')
        ->where('id', $id)
        ->where('tutor_id', auth()->id())
        ->first();

    if (!$recurso) {
        abort(404, 'Recurso no encontrado');
    }

    if ($recurso->tipo === 'enlace') {
        return redirect($recurso->enlace);
    }

    // Verificar que el archivo existe
    if (!$recurso->archivo) {
        abort(404, 'Archivo no disponible');
    }

    // Ruta corregida - usar Storage facade
    $filePath = 'public/recursos/' . $recurso->archivo;
    
    if (!Storage::exists($filePath)) {
        // Si no existe con Storage, intentar con file_exists
        $alternativePath = storage_path('app/' . $filePath);
        if (!file_exists($alternativePath)) {
            abort(404, "Archivo no encontrado. Ruta: " . $filePath);
        }
        $filePath = $alternativePath;
        return response()->download($filePath, $recurso->nombre . '.' . pathinfo($recurso->archivo, PATHINFO_EXTENSION));
    }

    // Usar Storage para la descarga
    return Storage::download($filePath, $recurso->nombre . '.' . pathinfo($recurso->archivo, PATHINFO_EXTENSION));
}
public function debugRecursos()
{
    $recursos = DB::table('recursos')->where('tutor_id', auth()->id())->get();
    
    $debugInfo = [];
    foreach ($recursos as $recurso) {
        if ($recurso->archivo) {
            $debugInfo[] = [
                'id' => $recurso->id,
                'nombre' => $recurso->nombre,
                'archivo' => $recurso->archivo,
                'storage_exists' => Storage::exists('public/recursos/' . $recurso->archivo),
                'file_exists' => file_exists(storage_path('app/public/recursos/' . $recurso->archivo)),
                'public_exists' => file_exists(public_path('storage/recursos/' . $recurso->archivo)),
            ];
        }
    }
    return response()->json($debugInfo);
}
public function solicitudes()
{
    $tutor_id = auth()->id();
    
    // Obtener todas las solicitudes para este tutor
    $solicitudes = DB::table('solicitudes')
        ->join('users', 'solicitudes.id_estudiante', '=', 'users.id')
        ->where(function($query) use ($tutor_id) {
            $query->where('solicitudes.id_tutor', $tutor_id)
                  ->orWhereNull('solicitudes.id_tutor');
        })
        ->where('solicitudes.estado', 'pendiente')
        ->select('solicitudes.*', 'users.name as estudiante_nombre')
        ->orderBy('solicitudes.created_at', 'desc')
        ->get();

    // Pasar las variables necesarias para la vista
    return view('tutor', array_merge(
        compact('solicitudes'),
        $this->getDashboardData() // Método para obtener datos comunes
    ));
}

// Método auxiliar para obtener datos del dashboard
private function getDashboardData()
{
    $tutor_id = auth()->id();
    
    return [
        'tutorias_programadas' => DB::table('tutorias')
            ->where('id_tutor', $tutor_id)
            ->where('fecha', '>=', now()->format('Y-m-d'))
            ->orderBy('fecha', 'asc')
            ->get(),
        'tutorias_pasadas' => DB::table('tutorias')
            ->where('id_tutor', $tutor_id)
            ->where('fecha', '<', now()->format('Y-m-d'))
            ->orderBy('fecha', 'desc')
            ->get(),
        'estudiantes' => DB::table('users')
            ->where('role', 'estudiante')
            ->get(),
        'recursos' => DB::table('recursos')
            ->where('tutor_id', $tutor_id)
            ->orderBy('created_at', 'desc')
            ->get(),
        'asistencias_recientes' => collect([]) // Datos opcionales
    ];
}

public function tomarSolicitud($id)
{
    try {
        DB::table('solicitudes')
            ->where('id', $id)
            ->update([
                'id_tutor' => Auth::id(),
                'estado' => 'en_proceso',
                'updated_at' => now(),
            ]);

        return redirect()->route('tutor.solicitudes')->with('success', 'Has tomado la solicitud correctamente.');

    } catch (\Exception $e) {
        \Log::error('Error tomando solicitud: ' . $e->getMessage());
        return redirect()->route('tutor.solicitudes')->with('error', 'Error al tomar la solicitud.');
    }
}

public function responderSolicitud(Request $request, $id)
{
    $request->validate([
        'respuesta' => 'required|string',
        'estado' => 'required|string'
    ]);

    try {
        DB::table('solicitudes')
            ->where('id', $id)
            ->update([
                'respuesta' => $request->respuesta,
                'estado' => $request->estado,
                'fecha_respuesta' => now(),
                'updated_at' => now(),
            ]);

        return redirect()->route('tutor.solicitudes')->with('success', 'Respuesta enviada correctamente.');

    } catch (\Exception $e) {
        \Log::error('Error respondiendo solicitud: ' . $e->getMessage());
        return redirect()->route('tutor.solicitudes')->with('error', 'Error al enviar la respuesta.');
    }
}
public function getSolicitudesData()
{
    $tutor_id = auth()->id();
    
    $solicitudes = DB::table('solicitudes')
        ->join('users', 'solicitudes.id_estudiante', '=', 'users.id')
        ->where(function($query) use ($tutor_id) {
            $query->where('solicitudes.id_tutor', $tutor_id)
                  ->orWhereNull('solicitudes.id_tutor');
        })
        ->where('solicitudes.estado', 'pendiente')
        ->select('solicitudes.*', 'users.name as estudiante_nombre')
        ->orderBy('solicitudes.created_at', 'desc')
        ->get();

    return response()->json(['solicitudes' => $solicitudes]);
}
}