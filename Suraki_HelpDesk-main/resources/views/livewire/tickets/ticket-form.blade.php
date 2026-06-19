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
                    <form wire:submit.prevent="save" class="space-y-6 max-w-2xl mx-auto bg-white p-8 rounded-xl border border-suraki-neutral-dark">
                        <!-- Header -->
                        <div class="border-b border-suraki-neutral-dark pb-4">
                            <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Información del Problema</h3>
                            <p class="text-sm text-suraki-tertiary mt-1">Completa todos los campos para registrar tu incidencia.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="sucursal_id" value="Sucursal" />
                                <select wire:model="sucursal_id" id="sucursal_id" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm transition-colors duration-150" required>
                                    <option value="">Seleccione Sucursal</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('sucursal_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label value="Fecha y Hora de Solicitud" />
                                <x-text-input type="text" class="mt-1 block w-full bg-suraki-neutral/50 text-suraki-tertiary cursor-not-allowed" wire:model="fecha_hora" disabled />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="title" value="Título del Problema" />
                            <x-text-input wire:model="title" id="title" type="text" class="mt-1 block w-full" required autofocus placeholder="Ej. No enciende la computadora" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Descripción Detallada" />
                            <textarea wire:model="description" id="description" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm transition-colors duration-150" rows="4" required placeholder="Describe el problema con el mayor detalle posible..."></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="departamento_id" value="Área o Departamento" />
                                <select wire:model="departamento_id" id="departamento_id" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm transition-colors duration-150" required>
                                    <option value="">Seleccione un Área</option>
                                    @foreach($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('departamento_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="priority" value="Prioridad" />
                                <select wire:model="priority" id="priority" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm transition-colors duration-150" required>
                                    <option value="baja">Baja</option>
                                    <option value="media">Media</option>
                                    <option value="alta">Alta</option>
                                    <option value="critica">Crítica (Emergencia)</option>
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
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
