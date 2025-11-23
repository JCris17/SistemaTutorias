<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = session('user');
        
        // Verificar si el usuario está autenticado
        if (!$user) {
            return redirect()->route('landingpage')
                ->with('error', 'Por favor inicia sesión.');
        }

        // Verificar si el usuario tiene el rol requerido
        if ($user->role !== $role) {
            return redirect()->route('landingpage')
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}