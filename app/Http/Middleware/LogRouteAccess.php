<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RouteLog;

class LogRouteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo registrar si el usuario está logueado, y si NO es una solicitud ajax/livewire (para no inundar de logs de componentes)
        if (auth()->check() && !$request->ajax() && !$request->is('livewire/*') && !$request->is('up')) {
            RouteLog::create([
                'user_id' => auth()->id(),
                'url' => substr($request->fullUrl(), 0, 1000),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent(), 0, 1000)
            ]);
        }

        return $next($request);
    }
}
