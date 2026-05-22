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
        // 1. Verifica se o utilizador está autenticado
        if (!$request->user()) {
            abort(403, 'Não autenticado.');
        }

        // 2. Verifica se o user_type do utilizador está na lista de roles permitidos
        if (!in_array($request->user()->user_type, $roles)) {
            // Se não estiver, bloqueia o acesso com um erro 403 (Proibido)
            abort(403, 'Acesso não autorizado a esta área.');
        }

        // 3. Se estiver tudo bem, deixa passar para o Controller
        return $next($request);
    }
}