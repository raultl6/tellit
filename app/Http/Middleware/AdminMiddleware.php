<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Middleware personalizado que restringe el acceso a las rutas de administración.
// Se registra en el Kernel y se aplica a las rutas del grupo 'admin' en web.php
class AdminMiddleware
{
    /**
     * Intercepta la petición antes de que llegue al controlador.
     * Si el usuario está autenticado y tiene rol 'admin', la petición continúa.
     * Si no cumple la condición, se le redirige al inicio con un mensaje de error.
     */
    public function handle(Request $request, Closure $next)
    {
        // Auth::check() verifica que haya sesión activa.
        // Auth::user()->role comprueba que el campo 'role' del usuario sea 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // $next($request) permite que la petición siga su camino normal hacia el controlador
            return $next($request);
        }

        // Si no es admin, se redirige a la página de inicio con un mensaje de error en la sesión
        return redirect('/')->with('error', 'No tienes permisos de administrador.');
    }
}
