<?php

namespace App\Http\Middleware;

use App\Models\Acceso;
use Closure;
use Illuminate\Http\Request;

class ValidateRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ruta = $request->route()->getName();
        $permisos = auth()->user()->getPermisos();
        $acceso = $permisos->where('ruta', $ruta)->first();
        if ((isset($acceso) && isset($acceso->permisos) && $acceso->permisos->visualizar) || $ruta == 'home' || auth()->user()->isAdmin()) {
            return $next($request);
        }
        abort(404);
    }
}
