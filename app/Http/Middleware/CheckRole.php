<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permisos para acceder a esta página.');
=======

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
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
    }
}