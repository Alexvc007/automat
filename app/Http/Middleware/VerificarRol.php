<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Uso en rutas: ->middleware('rol:admin') o ->middleware('rol:admin,trabajador')
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $permitidos = explode(',', $roles);

        if (!$request->user() || !in_array($request->user()->rol, $permitidos)) {
            abort(403, 'No tienes permiso para acceder a este módulo.');
        }

        if ($request->user()->estado !== 'activo') {
            auth()->logout();
            return redirect('/login')->withErrors(['correo' => 'Tu cuenta está desactivada. Contacta al administrador.']);
        }

        return $next($request);
    }
}
