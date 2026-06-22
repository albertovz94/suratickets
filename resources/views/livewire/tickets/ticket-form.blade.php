<div>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-xl text-suraki-secondary leading-tight">
            {{ __('Crear Nuevo Ticket') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card-suraki">
                <div class="p-6">
                    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-6 md:p-8 space-y-6">
                        @if(!$is_it_available)
                            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 flex items-start gap-3 mb-6">
                                <svg class="w-6 h-6 text-orange-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <div>
                                    <h3 class="font-bold text-orange-800">Atención: Fuera de Horario Laboral de Sistemas</h3>
                                    <p class="text-sm text-orange-700 mt-1">
                                        Actualmente no hay personal del departamento de Sistemas en turno. Puedes reportar tu problema, pero ten en cuenta que tu ticket será atendido a primera hora en el próximo turno laboral disponible.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Header -->
                        <div class="border-b border-suraki-neutral-dark pb-4">
                            <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Información del Problema</h3>
                            <p class="text-sm text-suraki-tertiary mt-1">Completa todos los campos para registrar tu incidencia.</p>
                        </div>

                        <!-- Datos del Solicitante (Solo Lectura) -->
                        <div class="bg-suraki-neutral p-4 rounded-xl border border-suraki-neutral-dark flex items-center gap-4 mb-6">
                            <div class="flex-shrink-0">
                                @if(auth()->user()->avatar_path)
                                    <img src="{{ auth()->user()->avatar_path }}" alt="Avatar" class="w-14 h-14 rounded-lg object-cover shadow-sm">
                                @else
                                    <div class="w-14 h-14 rounded-lg bg-suraki-primary text-white flex items-center justify-center font-bold font-heading text-xl shadow-sm">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-bold text-suraki-secondary">{{ auth()->user()->display_name ?? auth()->user()->name }}</h4>
                                <div class="text-sm text-suraki-tertiary mt-1 flex flex-wrap gap-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        {{ auth()->user()->email }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        {{ optional(auth()->user()->sucursal)->nombre ?? 'Sin Sucursal' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        {{ optional(auth()->user()->departamento)->nombre ?? 'Sin Departamento' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles del Ticket -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="title" value="Título del Problema" />
                                <x-text-input wire:model="title" id="title" type="text" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary" required autofocus placeholder="Ej. No enciende la computadora" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="description" value="Descripción Detallada" />
                                <textarea wire:model="description" id="description" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary rounded-lg shadow-sm" rows="4" required placeholder="Describe el problema con el mayor detalle posible..."></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="priority" value="Nivel de Prioridad" />
                                <select wire:model="priority" id="priority" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary rounded-lg shadow-sm" required>
                                    <option value="baja">Baja</option>
                                    <option value="media">Media</option>
                                    <option value="alta">Alta</option>
                                    <option value="critica">Crítica (Emergencia)</option>
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                            </div>
                            
                            <div>
                                <x-input-label value="Fecha de Registro" />
                                <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 cursor-not-allowed border-suraki-neutral-dark" wire:model="fecha_hora" disabled />
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-suraki-neutral-dark">
                            <a href="{{ route('dashboard') }}" wire:navigate class="text-sm text-suraki-tertiary hover:text-suraki-secondary transition-colors duration-150 mr-4">
                                Cancelar
                            </a>
                            <x-primary-button wire:loading.attr="disabled">
                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Crear Ticket
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
