<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLanding()
    {
        // Si ya está logueado, redirigir según su rol
        if (session('user')) {
            $user = session('user');
            return $this->redirectByRole($user->role);
        }
        
        return view('landingpage');
    }

    public function register(Request $request)
    {
        Log::info('Datos recibidos en registro:', $request->all());

        // Validación inmediata de contraseña simple primero
        if (strlen($request->password) < 8) {
            Log::info('Validación fallida: contraseña muy corta');
            return redirect()->back()
                ->with('error', 'La contraseña debe tener al menos 8 caracteres.')
                ->withInput()
                ->with('showAuth', 'register');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ],
            'role' => 'required|in:coordinador,tutor,estudiante'
        ], [
            'password.regex' => 'La contraseña debe contener: 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial (@$!%*?&).',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ]);

        if ($validator->fails()) {
            Log::info('Validación fallida:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('showAuth', 'register');
        }

        try {
            Log::info('Intentando crear usuario...');
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Usuario creado exitosamente:', ['id' => $user->id, 'email' => $user->email]);

            return redirect()->route('landingpage')
                ->with('success', 'Usuario registrado correctamente. Ahora puedes iniciar sesión.')
                ->with('showAuth', 'login');

        } catch (\Exception $e) {
            Log::error('Error al crear usuario: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al registrar usuario: ' . $e->getMessage())
                ->withInput()
                ->with('showAuth', 'register');
        }
    }

    public function login(Request $request)
    {
        Log::info('Intento de login:', ['email' => $request->email]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Log::info('Validación de login fallida:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('showAuth', 'login');
        }

        // DEBUG: Ver todos los usuarios en la base de datos
        $allUsers = User::all();
        Log::info('Todos los usuarios en la BD:', $allUsers->toArray());

        $user = User::where('email', $request->email)
                    ->where('activo', 1) 
                    ->first();

        Log::info('Usuario encontrado:', $user ? $user->toArray() : ['usuario' => 'no encontrado']);

        if (!$user) {
            Log::info('Usuario no encontrado o inactivo');
            return redirect()->back()
                ->with('error', 'Usuario no encontrado o inactivo.')
                ->withInput()
                ->with('showAuth', 'login');
        }

        if (!Hash::check($request->password, $user->password)) {
            Log::info('Contraseña incorrecta');
            return redirect()->back()
                ->with('error', 'Contraseña incorrecta.')
                ->withInput()
                ->with('showAuth', 'login');
        }

        Log::info('Login exitoso:', ['user_id' => $user->id]);
        session(['user' => $user]);

        // Redirigir según el rol
        return $this->redirectByRole($user->role);
    }

    public function logout(Request $request)
    {
        // Limpiar sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('landingpage')
            ->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Redirige según el rol del usuario
     */
    private function redirectByRole($role)
    {
        Log::info('Redirigiendo por rol:', ['rol' => $role]);
        
        switch ($role) {
            case 'tutor':
                return redirect()->route('tutor');
            case 'coordinador':
                return redirect()->route('coordinador');
            case 'estudiante':
                return redirect()->route('estudiante');
            default:
                Log::warning('Rol no reconocido:', ['rol' => $role]);
                return redirect()->route('landingpage')
                    ->with('error', 'Rol de usuario no reconocido.');
        }
    }
}