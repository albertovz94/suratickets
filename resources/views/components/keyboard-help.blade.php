<div x-show="shortcutsModalOpen" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-75"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display: none;"
     role="dialog"
     aria-modal="true"
     aria-labelledby="shortcuts-title"
>
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="shortcutsModalOpen = false"></div>
    <div class="relative w-full max-w-lg rounded-2xl bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 p-6 shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 id="shortcuts-title" class="text-lg font-bold text-gray-900 dark:text-zinc-100 flex items-center gap-2">
                ⌨️ Atajos de Teclado
            </h3>
            <button @click="shortcutsModalOpen = false" class="text-gray-400 hover:text-gray-650 dark:hover:text-zinc-350">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600 dark:text-zinc-400">
            <div>
                <h4 class="font-bold text-gray-900 dark:text-zinc-100 mb-2 border-b pb-1">Navegación general</h4>
                <ul class="space-y-2">
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">g + d</span> <span>Ir a Inicio (Dashboard)</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">g + t</span> <span>Ir a Tickets</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">g + r</span> <span>Ir a Solicitudes IT</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">g + h</span> <span>Ir a Horarios IT</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">g + i</span> <span>Ir a Inventario</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">g + u</span> <span>Ir a Usuarios</span></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 dark:text-zinc-100 mb-2 border-b pb-1">Acciones Rápidas</h4>
                <ul class="space-y-2">
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">c + t</span> <span>Crear Ticket</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">c + r</span> <span>Crear Solicitud</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">/</span> <span>Buscar (Foco)</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">?</span> <span>Mostrar ayuda</span></li>
                    <li class="flex justify-between"><span class="font-semibold text-suraki-primary font-mono bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">Esc</span> <span>Cerrar Modal</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
