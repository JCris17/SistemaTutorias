<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
=======
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3

class AuthController extends Controller
{
    public function showLanding()
    {
<<<<<<< HEAD
        // Usa Auth::check() en lugar de session('user')
        if (Auth::check()) {
            $user = Auth::user();
=======
        // Si ya está logueado, redirigir según su rol
        if (session('user')) {
            $user = session('user');
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
            return $this->redirectByRole($user->role);
        }
        
        return view('landingpage');
    }

<<<<<<< HEAD
    public function showLogin()
    {
        // Usa Auth::check() en lugar de session('user')
        if (Auth::check()) {
            $user = Auth::user();
            return $this->redirectByRole($user->role);
        }
        
        return view('landingpage')->with('showAuth', 'login');
    }

=======
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
    public function register(Request $request)
    {
        Log::info('Datos recibidos en registro:', $request->all());

<<<<<<< HEAD
=======
        // Validación inmediata de contraseña simple primero
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
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
<<<<<<< HEAD
=======
                'created_at' => now(),
                'updated_at' => now()
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
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

<<<<<<< HEAD
=======
        // DEBUG: Ver todos los usuarios en la base de datos
        $allUsers = User::all();
        Log::info('Todos los usuarios en la BD:', $allUsers->toArray());

>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
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
<<<<<<< HEAD
        
        // Usa Auth::login() en lugar de session()
        Auth::login($user);
=======
        session(['user' => $user]);
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3

        // Redirigir según el rol
        return $this->redirectByRole($user->role);
    }

    public function logout(Request $request)
    {
<<<<<<< HEAD
        // Usa Auth::logout() en lugar de limpiar sesión manualmente
        Auth::logout();
=======
        // Limpiar sesión
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
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