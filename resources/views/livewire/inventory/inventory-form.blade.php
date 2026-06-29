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

                    <!-- Asignar a Usuario (Buscador Autocompletado) -->
                    <div class="md:col-span-2 relative" x-data="{ open: false }" @click.away="open = false">
                        <x-input-label for="userSearch" :value="__('Asignar a Usuario / Administrador')" />
                        <div class="relative mt-1">
                            <x-text-input 
                                wire:model.live="userSearch" 
                                id="userSearch" 
                                @focus="open = true" 
                                class="block w-full bg-white/50 pr-10" 
                                type="text" 
                                placeholder="Escribe el nombre, apellido o usuario para buscar..." 
                                autocomplete="off"
                            />
                            
                            @if($assigned_to)
                                <button type="button" 
                                    wire:click="$set('assigned_to', null); $set('userSearch', '');" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                    title="Quitar asignación"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                        <input type="hidden" wire:model="assigned_to">

                        <!-- Dropdown list -->
                        <div x-show="open && $wire.userSearch.length > 0" 
                             x-transition
                             class="absolute top-full left-0 z-50 mt-1 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto divide-y divide-gray-100"
                             style="display: none;"
                        >
                            @forelse($users as $user)
                                @php
                                    $fullName = trim($user->name . ' ' . ($user->last_name ?? ''));
                                @endphp
                                <button type="button" 
                                    x-on:mousedown.prevent="
                                        $wire.set('assigned_to', {{ $user->id }}); 
                                        $wire.set('userSearch', '{{ addslashes($fullName) }}'); 
                                        $wire.set('branch_id', '{{ $user->branch_id ?? '' }}');
                                        $wire.set('department_id', '{{ $user->department_id ?? '' }}');
                                        open = false;
                                    "
                                    class="w-full text-left px-4 py-3 text-sm hover:bg-suraki-neutral transition-colors flex items-center justify-between"
                                >
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $user->name }} {{ $user->last_name }}</p>
                                        <p class="text-xs text-gray-500 font-mono">
                                            {{ $user->username }} | {{ $user->email }} | <span class="text-suraki-primary font-semibold">{{ optional($user->department)->name ?? 'Sin Departamento' }}</span>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->hasAdminAccess() ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-700 border border-gray-200' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </button>
                            @empty
                                <div class="px-4 py-3 text-sm text-gray-500 text-center">No se encontraron usuarios</div>
                            @endforelse
                        </div>
                        <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
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
