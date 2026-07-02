<?php

namespace App\Http\Middleware;

use App\Models\RouteLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogRouteRequests
{
    /**
     * Handle an incoming request and log the route access.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Perform logging after response is sent (terminate/post-processing)
        // Skip debug requests, static files, or livewire updates to keep database clean
        $url = $request->fullUrl();
        $path = $request->path();

        if ($request->isMethod('GET') &&
            !$request->routeIs('livewire.*') &&
            !str_starts_with($path, 'livewire/') &&
            !str_starts_with($path, '_') &&
            !$request->expectsJson()
        ) {
            try {
                RouteLog::create([
                    'user_id' => Auth::id(),
                    'url' => substr($url, 0, 1000),
                    'method' => $request->method(),
                    'ip_address' => $request->ip(),
                    'user_agent' => substr($request->userAgent(), 0, 500),
                ]);
            } catch (\Exception $e) {
                // Fail silently to avoid breaking the application request lifecycle on DB issue
            }

            // Audit sensitive administration reads
            if (Auth::check() && Auth::user()->hasAdminAccess()) {
                $sensitivePaths = ['usuarios', 'configuracion', 'reportes', 'inventario'];
                foreach ($sensitivePaths as $sensitivePath) {
                    if (str_starts_with($path, $sensitivePath)) {
                        \App\Services\ActivityLogger::log(
                            'admin_read_sensitive',
                            null,
                            "El administrador leyó información sensible en la ruta: /{$path}"
                        );
                        break;
                    }
                }
            }
        }

        return $response;
    }
}
