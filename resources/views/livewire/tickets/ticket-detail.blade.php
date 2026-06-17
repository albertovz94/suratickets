<div x-data="{ show: @entangle('showDetailModal') }" 
     x-show="show" 
     style="display: none;" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="show" 
             @click.away="show = false; $wire.closeModal()"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            
            @if($ticket)
            <div class="bg-gray-50 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4 border-b pb-4">
                    <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                        Detalle de Ticket #{{ $ticket->id }}
                    </h3>
                    <button @click="show = false" wire:click="closeModal" type="button" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Columna Izquierda: Información del Ticket -->
                        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow space-y-4">
                            <div>
                                <h3 class="text-2xl font-bold text-indigo-700">{{ $ticket->title }}</h3>
                                <div class="flex gap-2 mt-2">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $ticket->priority == 'critica' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        Prioridad: {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase">Descripción del Problema</h4>
                                <p class="mt-2 text-gray-800 whitespace-pre-wrap">{{ $ticket->description }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-md">
                                <div>
                                    <p class="text-sm font-semibold text-gray-500">Sucursal</p>
                                    <p class="text-gray-900">{{ $ticket->sucursal->nombre }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500">Área / Depto</p>
                                    <p class="text-gray-900">{{ $ticket->area_departamento }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500">Equipo Afectado</p>
                                    <p class="text-gray-900">{{ $ticket->equipo_afectado }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500">Creado Por</p>
                                    <p class="text-gray-900">{{ $ticket->creator->name }} ({{ $ticket->creator->username }})</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->created_at->format('d/m/Y H:i A') }}</p>
                                </div>
                            </div>
                            
                            @if(auth()->user()->rol !== 'admin' && $ticket->resolution_summary)
                            <div class="mt-4 bg-green-50 p-4 border border-green-200 rounded-md">
                                <h4 class="text-sm font-semibold text-green-800 uppercase">Respuesta del Técnico</h4>
                                <p class="mt-2 text-green-900 whitespace-pre-wrap">{{ $ticket->resolution_summary }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Columna Derecha: Acciones del Administrador -->
                        <div>
                            @if(auth()->user()->rol === 'admin')
                                <div class="bg-white p-6 rounded-lg shadow">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Gestión de Ticket</h3>
                                    
                                    <form wire:submit.prevent="updateTicket" class="space-y-4">
                                            <!-- Status removed due to automation -->

                                        <div>
                                            <x-input-label for="assigned_to" value="Asignar a" />
                                            <select wire:model="assigned_to" id="assigned_to" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">-- Sin Asignar --</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="resolution_summary" value="Resumen / Resolución" />
                                            <textarea wire:model="resolution_summary" id="resolution_summary" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" placeholder="Escribe aquí la solución para el usuario..."></textarea>
                                            <x-input-error :messages="$errors->get('resolution_summary')" class="mt-2" />
                                        </div>

                                        <div class="pt-4">
                                            <x-primary-button class="w-full justify-center">
                                                Guardar Cambios
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <!-- Vista del usuario para la columna derecha -->
                                <div class="bg-indigo-50 p-6 rounded-lg shadow border border-indigo-100">
                                    <h3 class="text-lg font-medium text-indigo-900 mb-2">Estado del Soporte</h3>
                                    <p class="text-sm text-indigo-700">Tu ticket está actualmente <strong>{{ str_replace('_', ' ', $ticket->status) }}</strong>.</p>
                                    @if($ticket->assignedTo)
                                        <p class="text-sm text-indigo-700 mt-2">Ha sido asignado al técnico: <strong>{{ $ticket->assignedTo->name }}</strong>.</p>
                                    @else
                                        <p class="text-sm text-indigo-700 mt-2">Pronto un administrador será asignado a tu caso.</p>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="mt-4">
                                <button @click="show = false" wire:click="closeModal" type="button" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                                    &larr; Cerrar Ventana
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
