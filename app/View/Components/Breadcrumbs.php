<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public array $breadcrumbs = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->breadcrumbs = $this->buildBreadcrumbs();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.breadcrumbs');
    }

    /**
     * Build the breadcrumbs array dynamically based on the current route.
     */
    private function buildBreadcrumbs(): array
    {
        $route = request()->route();
        if (!$route) {
            return [];
        }

        $routeName = $route->getName();
        $breadcrumbs = [];

        if ($routeName && $routeName !== 'login' && $routeName !== 'register') {
            $breadcrumbs[] = [
                'label' => 'Inicio',
                'url' => auth()->user() && auth()->user()->hasAdminAccess() ? route('dashboard') : route('tickets.index'),
                'icon' => 'home'
            ];
        }

        if ($routeName === 'profile') {
            $breadcrumbs[] = ['label' => 'Mi Perfil', 'url' => null];
        } elseif (str_starts_with($routeName, 'tickets.')) {
            $breadcrumbs[] = ['label' => 'Tickets', 'url' => route('tickets.index')];
            if ($routeName === 'tickets.create') {
                $breadcrumbs[] = ['label' => 'Nuevo Ticket', 'url' => null];
            } elseif ($routeName === 'tickets.show') {
                $breadcrumbs[] = ['label' => 'Detalle del Ticket', 'url' => null];
            }
        } elseif (str_starts_with($routeName, 'requests.')) {
            $breadcrumbs[] = ['label' => 'Solicitudes IT', 'url' => route('requests.index')];
            if ($routeName === 'requests.create') {
                $breadcrumbs[] = ['label' => 'Nueva Solicitud', 'url' => null];
            }
        } elseif (str_starts_with($routeName, 'schedules.')) {
            $breadcrumbs[] = ['label' => 'Horarios IT', 'url' => route('schedules.index')];
            if ($routeName === 'schedules.config') {
                $breadcrumbs[] = ['label' => 'Configuración', 'url' => null];
            } elseif ($routeName === 'schedules.outsourcing') {
                $breadcrumbs[] = ['label' => 'Outsourcing', 'url' => null];
            }
        } elseif (str_starts_with($routeName, 'inventory.')) {
            $breadcrumbs[] = ['label' => 'Inventario', 'url' => route('inventory.index')];
            if ($routeName === 'inventory.create') {
                $breadcrumbs[] = ['label' => 'Nuevo Equipo', 'url' => null];
            } elseif ($routeName === 'inventory.edit') {
                $breadcrumbs[] = ['label' => 'Editar Equipo', 'url' => null];
            }
        } elseif (str_starts_with($routeName, 'users.')) {
            $breadcrumbs[] = ['label' => 'Usuarios', 'url' => route('users.index')];
            if ($routeName === 'users.create') {
                $breadcrumbs[] = ['label' => 'Nuevo Usuario', 'url' => null];
            } elseif ($routeName === 'users.edit') {
                $breadcrumbs[] = ['label' => 'Editar Usuario', 'url' => null];
            }
        } elseif ($routeName === 'reports.index') {
            $breadcrumbs[] = ['label' => 'Reportes', 'url' => null];
        } elseif ($routeName === 'settings.index') {
            $breadcrumbs[] = ['label' => 'Configuración', 'url' => null];
        }

        return $breadcrumbs;
    }
}
