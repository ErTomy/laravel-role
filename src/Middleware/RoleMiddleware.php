<?php

namespace Ertomy\Roles\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Verificar si el usuario tiene el rol requerido
        if (Auth::check() && auth()->user()->hasRole($roles)) {
            return $next($request);
        }

        // Redirigir o mostrar un error en caso contrario
        return redirect()->route('login');
    }
}
