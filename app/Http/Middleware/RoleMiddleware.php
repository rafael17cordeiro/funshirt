<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {

        if (!$request->user()) {
            abort(403, 'Não autenticado.');
        }


        if (!in_array($request->user()->user_type, $roles)) {
            // Se não estiver, bloqueia o acesso com um erro 403 (Proibido)
            abort(403, 'Acesso não autorizado a esta área.');
        }


        return $next($request);
    }
}
