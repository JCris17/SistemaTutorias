<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuthSession
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si existe usuario en sesión
        if (!session('user')) {
            return redirect()->route('landingpage')
                ->with('error', 'Por favor inicia sesión para acceder a esta página.');
        }

        return $next($request);
    }
}