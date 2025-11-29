<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function dashboard()
    {
        // Obtener datos para el dashboard
        $tutor_id = session('user_id', 2);
        
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

        return view('tutor', compact('tutorias_programadas', 'tutorias_pasadas', 'estudiantes'));
    }
public function registrarAsistencia(Request $request)
{
    $request->validate([
        'tutoria_id' => 'required|exists:tutorias,id',
        'asistencias' => 'required|array',
        'asistencias.*.estudiante_id' => 'required|exists:estudiantes,id',
        'asistencias.*.asistio' => 'required|boolean',
        'asistencias.*.observaciones' => 'nullable|string'
    ]);

    foreach ($request->asistencias as $asistencia) {
        Asistencia::updateOrCreate(
            [
                'tutoria_id' => $request->tutoria_id,
                'estudiante_id' => $asistencia['estudiante_id']
            ],
            [
                'asistio' => $asistencia['asistio'],
                'observaciones' => $asistencia['observaciones']
            ]
        );
    }

    return back()->with('success', 'Asistencia registrada correctamente');
}
public function actualizarHorario(Request $request)
{
    $request->validate([
        'dias' => 'required|array',
        'dias.*.dia' => 'required|string',
        'dias.*.hora_inicio' => 'required|date_format:H:i',
        'dias.*.hora_fin' => 'required|date_format:H:i|after:dias.*.hora_inicio'
    ]);

    // Eliminar horarios existentes
    HorarioTutor::where('tutor_id', auth()->id())->delete();

    // Crear nuevos horarios
    foreach ($request->dias as $dia) {
        HorarioTutor::create([
            'tutor_id' => auth()->id(),
            'dia_semana' => $dia['dia'],
            'hora_inicio' => $dia['hora_inicio'],
            'hora_fin' => $dia['hora_fin']
        ]);
    }

    return back()->with('success', 'Horario actualizado correctamente');
}
public function estudiantes()
{
    $estudiantes = Estudiante::where('tutor_id', auth()->id())
        ->with(['asistencias', 'tutorias'])
        ->get()
        ->map(function($estudiante) {
            $estudiante->porcentaje_asistencia = $this->calcularAsistencia($estudiante);
            $estudiante->ultima_tutoria = $estudiante->tutorias()->latest()->first();
            return $estudiante;
        });

    return view('tutor.estudiantes', compact('estudiantes'));
}

private function calcularAsistencia($estudiante)
{
    $total = $estudiante->asistencias->count();
    if ($total === 0) return 0;
    
    $presentes = $estudiante->asistencias->where('asistio', true)->count();
    return round(($presentes / $total) * 100);
}
public function subirRecurso(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|in:documento,presentacion,video,enlace',
        'archivo' => 'required_if:tipo,documento,presentacion,video|file|max:10240',
        'enlace' => 'required_if:tipo,enlace|url',
        'descripcion' => 'nullable|string'
    ]);

    $rutaArchivo = null;
    if ($request->hasFile('archivo')) {
        $rutaArchivo = $request->file('archivo')->store('recursos', 'public');
    }

    Recurso::create([
        'tutor_id' => auth()->id(),
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
        'archivo' => $rutaArchivo,
        'enlace' => $request->enlace,
        'descripcion' => $request->descripcion,
        'tamaño' => $request->file('archivo') ? $request->file('archivo')->getSize() : null
    ]);

    return back()->with('success', 'Recurso subido correctamente');
}
}