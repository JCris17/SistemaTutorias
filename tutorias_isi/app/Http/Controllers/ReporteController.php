<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Tutoria;

class ReporteController extends Controller
{
    public function tutoriasPorEstudiante()
{
    $tutorias = Tutoria::with('estudiante')->get();
    $pdf = Pdf::loadView('reportes.tutorias_por_estudiante', compact('tutorias'));
    return $pdf->download('tutorias_por_estudiante.pdf');
}
}
