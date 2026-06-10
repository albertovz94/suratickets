<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div>
                            <x-input-label for="title" value="Título del Problema" />
                            <x-text-input wire:model="title" id="title" type="text" class="mt-1 block w-full" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Descripción Detallada" />
                            <textarea wire:model="description" id="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="sucursal_id" value="Sucursal" />
                                <select wire:model="sucursal_id" id="sucursal_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione Sucursal</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('sucursal_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="area_departamento" value="Área o Departamento" />
                                <x-text-input wire:model="area_departamento" id="area_departamento" type="text" class="mt-1 block w-full" placeholder="Ej. Caja 1, Gerencia" required />
                                <x-input-error :messages="$errors->get('area_departamento')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="equipo_afectado" value="Equipo Afectado" />
                                <x-text-input wire:model="equipo_afectado" id="equipo_afectado" type="text" class="mt-1 block w-full" placeholder="Ej. PC-01, Impresora" required />
                                <x-input-error :messages="$errors->get('equipo_afectado')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="priority" value="Prioridad" />
                                <select wire:model="priority" id="priority" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="baja">Baja</option>
                                    <option value="media">Media</option>
                                    <option value="alta">Alta</option>
                                    <option value="critica">Crítica (Emergencia)</option>
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                            </div>
                        </div>

        <div class="flex items-center justify-end mt-4 pt-4 border-t border-gray-200">
            <button type="button" @click="$dispatch('close-ticket-modal')" class="text-sm text-gray-600 hover:text-gray-900 focus:outline-none mr-4">
                Cancelar
            </button>
            <x-primary-button>
                Crear Ticket
            </x-primary-button>
        </div>
    </form>
</div>
