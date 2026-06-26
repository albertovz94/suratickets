<div class="py-12 animate-fade-in">
    <div class="max-w-[1600px] w-full mx-auto sm:px-6 lg:px-8">
        <!-- Encabezado con efecto Glassmorphism -->
        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-2xl border border-white/50 mb-6">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">
                            {{ $device_id ? 'Editar Equipo' : 'Nuevo Equipo' }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">Completa la información del equipo tecnológico para tu inventario.</p>
                    </div>
                    <a href="{{ route('inventory.index') }}" wire:navigate class="blob-btn shadow-md text-sm" style="max-width: 150px; padding: 10px 20px;">
                        <span style="position:relative; z-index: 10;">Volver</span>
                        <span class="blob-btn__inner"><span class="blob-btn__blobs"><span class="blob-btn__blob"></span><span class="blob-btn__blob"></span><span class="blob-btn__blob"></span><span class="blob-btn__blob"></span></span></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-2xl border border-white/50 p-8">
            <form wire:submit="save" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <x-input-label for="name" :value="__('Nombre del Equipo')" />
                        <x-text-input wire:model="name" id="name" class="block mt-1 w-full bg-white/50" type="text" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Número de Serie -->
                    <div>
                        <x-input-label for="serial_number" :value="__('Número de Serie')" />
                        <x-text-input wire:model="serial_number" id="serial_number" class="block mt-1 w-full bg-white/50" type="text" required />
                        <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                    </div>

                    <!-- Especificaciones -->
                    <div class="md:col-span-2">
                        <x-input-label for="specs" :value="__('Especificaciones (CPU, RAM, Disco, etc.)')" />
                        <x-text-input wire:model="specs" id="specs" class="block mt-1 w-full bg-white/50" type="text" />
                        <x-input-error :messages="$errors->get('specs')" class="mt-2" />
                    </div>

                    <!-- Tipo -->
                    <div>
                        <x-input-label for="type" :value="__('Tipo de Equipo')" />
                        <select wire:model="type" id="type" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                            <option value="Laptop">Laptop</option>
                            <option value="Desktop">Desktop</option>
                            <option value="Servidor">Servidor</option>
                            <option value="Red">Equipos de Red</option>
                            <option value="Impresora">Impresora</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <!-- Estado -->
                    <div>
                        <x-input-label for="status" :value="__('Estado')" />
                        <select wire:model="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                            <option value="Activo">Activo</option>
                            <option value="En reparacion">En reparación</option>
                            <option value="De baja">De baja</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Sucursal -->
                    <div>
                        <x-input-label for="branch_id" :value="__('Sucursal')" />
                        <select wire:model="branch_id" id="branch_id" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                            <option value="">-- Seleccionar Sucursal --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                    </div>

                    <!-- Departamento -->
                    <div>
                        <x-input-label for="department_id" :value="__('Departamento')" />
                        <select wire:model="department_id" id="department_id" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                            <option value="">-- Seleccionar Departamento --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8">
                    <x-btn-panel type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto" style="min-width: 200px;">
                        {{ __('Guardar Equipo') }}
                    </x-btn-panel>
                </div>
            </form>
        </div>
    </div>
</div>
