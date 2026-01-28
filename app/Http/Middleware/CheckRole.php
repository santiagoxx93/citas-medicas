<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // Fíjate en los 3 puntos ...$roles (eso permite recibir varios roles)
// Fíjate en los 3 puntos ...$roles (eso permite recibir varios roles)
public function handle(Request $request, Closure $next, ...$roles): Response
{
    // Verifica si el rol del usuario está en la lista de permitidos
    if (! $request->user() || ! in_array($request->user()->role, $roles)) {
        abort(403, 'NO TIENES PERMISO PARA ACCEDER A ESTA SECCIÓN.');
    }

    return $next($request);
}
}
