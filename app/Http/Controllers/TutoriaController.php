<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutoriaController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validar los datos
            $validated = $request->validate([
                'tema' => 'required|string|max:255',
                'id_estudiante' => 'required|integer',
                'fecha' => 'required|date',
                'hora_inicio' => 'required',
                'hora_fin' => 'required',
                'observaciones' => 'nullable|string',
            ]);

            // Obtener ID del tutor desde la sesión
            $tutor_id = session('user_id', 2); // Usar 2 como fallback (Rodrigo)

            // Insertar en la base de datos
            DB::table('tutorias')->insert([
                'id_estudiante' => $validated['id_estudiante'],
                'id_tutor' => $tutor_id,
                'tema' => $validated['tema'],
                'fecha' => $validated['fecha'],
                'hora_inicio' => $validated['hora_inicio'],
                'hora_fin' => $validated['hora_fin'],
                'observaciones' => $validated['observaciones'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('tutor')->with('success', 'Tutoría creada exitosamente');

        } catch (\Exception $e) {
            return redirect()->route('tutor')->with('error', 'Error al crear tutoría: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'tema' => 'required|string|max:255',
                'id_estudiante' => 'required|integer',
                'fecha' => 'required|date',
                'hora_inicio' => 'required',
                'hora_fin' => 'required',
                'observaciones' => 'nullable|string',
            ]);

            DB::table('tutorias')
                ->where('id', $id)
                ->update([
                    'tema' => $validated['tema'],
                    'id_estudiante' => $validated['id_estudiante'],
                    'fecha' => $validated['fecha'],
                    'hora_inicio' => $validated['hora_inicio'],
                    'hora_fin' => $validated['hora_fin'],
                    'observaciones' => $validated['observaciones'],
                    'updated_at' => now(),
                ]);

            return redirect()->route('tutor')->with('success', 'Tutoría actualizada exitosamente');

        } catch (\Exception $e) {
            return redirect()->route('tutor')->with('error', 'Error al actualizar tutoría: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('tutorias')->where('id', $id)->delete();
            return redirect()->route('tutor')->with('success', 'Tutoría cancelada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('tutor')->with('error', 'Error al cancelar tutoría: ' . $e->getMessage());
        }
    }
}
=======
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
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
