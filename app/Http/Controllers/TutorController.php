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
}