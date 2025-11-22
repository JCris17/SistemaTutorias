<?php

namespace App\Http\Controllers;

use App\Models\Tutoria;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Coordinador')) {
            $totalTutorias = Tutoria::count();
            $porTutor = Tutoria::selectRaw('id_tutor, count(*) as total')
                                ->groupBy('id_tutor')->with('tutor')->get();
            return view('dashboard.coordinador', compact('totalTutorias', 'porTutor'));
        }

        if ($user->hasRole('Tutor')) {
            $tutorias = Tutoria::where('id_tutor', $user->id)->count();
            return view('dashboard.tutor', compact('tutorias'));
        }

        if ($user->hasRole('Estudiante')) {
            $tutorias = Tutoria::where('id_estudiante', $user->id)->count();
            return view('dashboard.estudiante', compact('tutorias'));
        }
    }
}

