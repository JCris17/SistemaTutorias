<?php

namespace App\Http\Controllers;

use App\Models\Tutoria;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class TutoriaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Tutor')) {
            $tutorias = Tutoria::where('id_tutor', $user->id)->get();
        } elseif ($user->hasRole('Estudiante')) {
            $tutorias = Tutoria::where('id_estudiante', $user->id)->get();
        } else {
            $tutorias = Tutoria::all();
        }

        return view('tutorias.index', compact('tutorias'));
    }

    public function create()
    {
        $tutores = User::role('Tutor')->get();
        $estudiantes = User::role('Estudiante')->get();
        return view('tutorias.create', compact('tutores', 'estudiantes'));
    }

    public function store(Request $request)
    {
        Tutoria::create($request->all());
        return redirect()->route('tutorias.index')->with('success', 'Tutoría creada correctamente.');
    }

    public function show(Tutoria $tutoria)
    {
        return view('tutorias.show', compact('tutoria'));
    }

    public function edit(Tutoria $tutoria)
    {
        $tutores = User::role('Tutor')->get();
        $estudiantes = User::role('Estudiante')->get();
        return view('tutorias.edit', compact('tutoria', 'tutores', 'estudiantes'));
    }

    public function update(Request $request, Tutoria $tutoria)
    {
        $tutoria->update($request->all());
        return redirect()->route('tutorias.index')->with('success', 'Tutoría actualizada correctamente.');
    }

    public function destroy(Tutoria $tutoria)
    {
        $tutoria->delete();
        return redirect()->route('tutorias.index')->with('success', 'Tutoría eliminada correctamente.');
    }
}
