<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Ticket #') }}{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-gray-50">
                    
                    @if (session()->has('message'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

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
                                        <div>
                                            <x-input-label for="status" value="Estado" />
                                            <select wire:model="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="abierto">Abierto</option>
                                                <option value="asignado">Asignado</option>
                                                <option value="en_proceso">En Proceso</option>
                                                <option value="pendiente">Pendiente</option>
                                                <option value="resuelto">Resuelto</option>
                                                <option value="cerrado">Cerrado</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                        </div>

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
                                <a href="{{ route('dashboard') }}" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                                    &larr; Volver al Listado
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
