<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Añadir atributos SPA para Livewire wire:navigate
        \Illuminate\Support\Facades\Vite::useStyleTagAttributes(['data-navigate-track' => 'reload']);
        \Illuminate\Support\Facades\Vite::useScriptTagAttributes(['data-navigate-track' => 'reload']);
        \Illuminate\Support\Facades\Vite::usePreloadTagAttributes(['data-navigate-track' => 'reload']);

        \Illuminate\Support\Facades\Blade::component('breadcrumbs', \App\View\Components\Breadcrumbs::class);
        \Illuminate\Support\Facades\Blade::component('badge', \App\View\Components\Badge::class);

        // Registrar observador de Tickets para notificaciones de Telegram e in-app
        \App\Models\Ticket::observe(\App\Observers\TicketObserver::class);

        \Illuminate\Support\Facades\RateLimiter::for('global', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(100)->by($request->ip());
        });
    }
}
