<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public string $classes = '';
    public string $label = '';

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param string $value
     */
    public function __construct(
        public string $type,
        public string $value
    ) {
        $this->resolveStylesAndLabel();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.badge');
    }

    /**
     * Resolve Tailwind CSS styling classes and display label based on badge type and value.
     */
    private function resolveStylesAndLabel(): void
    {
        $val = strtolower($this->value);
        $type = strtolower($this->type);

        if ($type === 'priority' || $type === 'prioridad') {
            $this->label = ucfirst($val);
            $this->classes = match ($val) {
                'critica' => 'bg-red-100 text-red-800 dark:bg-red-950/40 dark:text-red-400 border border-red-200 dark:border-red-900/50',
                'alta' => 'bg-orange-100 text-orange-800 dark:bg-orange-950/40 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50',
                'media' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-900/50',
                'baja' => 'bg-gray-100 text-gray-800 dark:bg-zinc-800 dark:text-zinc-400 border border-gray-200 dark:border-zinc-700/50',
                default => 'bg-gray-100 text-gray-800 dark:bg-zinc-800 dark:text-zinc-400 border border-gray-200 dark:border-zinc-700/50',
            };
        } elseif ($type === 'status' || $type === 'estado') {
            $this->label = str_replace('_', ' ', ucfirst($val));
            $this->classes = match ($val) {
                'abierto', 'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-950/40 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-900/50',
                'asignado', 'en_proceso' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-900/50',
                'resuelto', 'entregado', 'activo' => 'bg-green-100 text-green-800 dark:bg-green-950/40 dark:text-green-400 border border-green-200 dark:border-green-900/50',
                'cerrado', 'rechazado', 'bloqueada', 'de_baja' => 'bg-red-100 text-red-800 dark:bg-red-950/40 dark:text-red-400 border border-red-200 dark:border-red-900/50',
                'en_reparacion' => 'bg-orange-100 text-orange-800 dark:bg-orange-950/40 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50',
                default => 'bg-gray-100 text-gray-800 dark:bg-zinc-800 dark:text-zinc-400 border border-gray-200 dark:border-zinc-700/50',
            };
        } elseif ($type === 'role' || $type === 'rol') {
            $this->label = ucfirst($val);
            $this->classes = match ($val) {
                'admin' => 'bg-green-100 text-green-700 dark:bg-green-950/40 dark:text-green-400 border border-green-200 dark:border-green-900/50',
                'outsourcing' => 'bg-purple-100 text-purple-700 dark:bg-purple-950/40 dark:text-purple-400 border border-purple-200 dark:border-purple-900/50',
                'usuario' => 'bg-gray-100 text-gray-700 dark:bg-zinc-800 dark:text-zinc-400 border border-gray-200 dark:border-zinc-700/50',
                default => 'bg-gray-100 text-gray-700 dark:bg-zinc-800 dark:text-zinc-400 border border-gray-200 dark:border-zinc-700/50',
            };
        } else {
            $this->label = ucfirst($val);
            $this->classes = 'bg-gray-100 text-gray-800 dark:bg-zinc-800 dark:text-zinc-400 border border-gray-200 dark:border-zinc-700/50';
        }
    }
}
