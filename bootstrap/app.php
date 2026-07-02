<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Force HTTPS in production
        if (env('APP_ENV') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Append security and audit middlewares to all web requests
        $middleware->web(append: [
            \App\Http\Middleware\CheckUserStatus::class,
            \App\Http\Middleware\LogRouteRequests::class,
            \App\Http\Middleware\AddContentSecurityPolicyHeaders::class,
            'throttle:global',
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
