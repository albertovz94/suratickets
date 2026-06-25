<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-heading font-bold text-2xl text-suraki-secondary leading-tight">
                    Inventario de Equipos
                </h2>
                <p class="text-sm text-suraki-tertiary mt-1">Gestiona todos los activos tecnológicos del departamento</p>
            </div>
            
            <div class="flex gap-3">
                <button class="px-4 py-2 bg-white border border-suraki-neutral-dark rounded-lg text-sm font-medium text-suraki-secondary hover:bg-gray-50 flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    Exportar
                </button>
                <a href="{{ route('inventory.create') }}" wire:navigate class="px-4 py-2 bg-suraki-primary hover:bg-suraki-primary-hover text-white rounded-lg text-sm font-bold flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Nuevo Equipo
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[1600px] w-full mx-auto sm:px-6 lg:px-8">
            
            <!-- Cards de Métricas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Totales -->
                <div class="bg-white p-6 rounded-2xl border border-suraki-neutral-dark flex flex-col justify-between shadow-sm relative">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-4xl font-black text-suraki-secondary">{{ $totalEquipos }}</h3>
                            <p class="text-sm text-suraki-tertiary mt-1">Equipos Totales</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                            +8 este mes
                        </span>
                    </div>
                </div>

                <!-- Activos -->
                <div class="bg-white p-6 rounded-2xl border border-suraki-neutral-dark flex flex-col justify-between shadow-sm relative">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-4xl font-black text-suraki-secondary">{{ $activos }}</h3>
                            <p class="text-sm text-suraki-tertiary mt-1">Activos</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                            90.1% disponibles
                        </span>
                    </div>
                </div>

                <!-- En Reparación -->
                <div class="bg-white p-6 rounded-2xl border border-suraki-neutral-dark flex flex-col justify-between shadow-sm relative">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-4xl font-black text-suraki-secondary">{{ $enReparacion }}</h3>
                            <p class="text-sm text-suraki-tertiary mt-1">En Reparación</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                            +2 esta semana
                        </span>
                    </div>
                </div>

                <!-- Dados de Baja -->
                <div class="bg-white p-6 rounded-2xl border border-suraki-neutral-dark flex flex-col justify-between shadow-sm relative">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-4xl font-black text-suraki-secondary">{{ $dadosBaja }}</h3>
                            <p class="text-sm text-suraki-tertiary mt-1">Dados de Baja</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                            -3 vs mes pasado
                        </span>
                    </div>
                </div>
            </div>

            <!-- Filtros y Búsqueda -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-suraki-neutral-dark rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-suraki-primary focus:border-suraki-primary" placeholder="Buscar por nombre, modelo, serial...">
                </div>

                <div class="flex gap-3 w-full md:w-auto">
                    <select wire:model.live="type" class="block w-full md:w-40 py-2 px-3 border border-suraki-neutral-dark bg-white rounded-lg text-sm focus:outline-none focus:ring-suraki-primary focus:border-suraki-primary">
                        <option value="">Todos los tipos</option>
                        @foreach($types as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="status" class="block w-full md:w-40 py-2 px-3 border border-suraki-neutral-dark bg-white rounded-lg text-sm focus:outline-none focus:ring-suraki-primary focus:border-suraki-primary">
                        <option value="">Todos los estados</option>
                        <option value="Activo">Activo</option>
                        <option value="En reparacion">En Reparación</option>
                        <option value="De baja">Dados de baja</option>
                    </select>

                    <select wire:model.live="branch_id" class="block w-full md:w-48 py-2 px-3 border border-suraki-neutral-dark bg-white rounded-lg text-sm focus:outline-none focus:ring-suraki-primary focus:border-suraki-primary">
                        <option value="">Todas las sucursales</option>
                        @foreach($branches as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="department_id" class="block w-full md:w-48 py-2 px-3 border border-suraki-neutral-dark bg-white rounded-lg text-sm focus:outline-none focus:ring-suraki-primary focus:border-suraki-primary">
                        <option value="">Todos los departamentos</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tabla de Inventario -->
            <div class="bg-white rounded-2xl border border-suraki-neutral-dark overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-12">
                                <input type="checkbox" class="rounded border-gray-300 text-suraki-primary focus:ring-suraki-primary">
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                EQUIPO
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                TIPO
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                SERIAL / ASSET TAG
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                SUCURSAL / DEPARTAMENTO
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                ASIGNADO A
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                ESTADO
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                ACCIONES
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($devices as $device)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-suraki-primary focus:ring-suraki-primary">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg {{ $device->type === 'Laptop' ? 'bg-red-50 text-red-500' : ($device->type === 'Desktop' ? 'bg-blue-50 text-blue-500' : ($device->type === 'Servidor' ? 'bg-purple-50 text-purple-500' : 'bg-gray-100 text-gray-500')) }} flex items-center justify-center flex-shrink-0">
                                        @if($device->type === 'Laptop' || $device->type === 'Desktop')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        @elseif($device->type === 'Servidor')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" /></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" /></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-suraki-secondary">{{ $device->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $device->specs }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $device->type }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $device->serial_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-600">{{ optional($device->branch)->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ optional($device->department)->name }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ optional($device->assignee)->name ?? '--' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <button 
                                        wire:click="cycleEquipoStatus({{ $device->id }})" 
                                        type="button" 
                                        class="relative inline-flex h-6 w-16 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $device->status === 'Activo' ? 'bg-emerald-500' : ($device->status === 'En reparacion' ? 'bg-orange-500' : 'bg-gray-400') }}" 
                                        role="switch" 
                                        aria-checked="{{ $device->status === 'Activo' ? 'true' : 'false' }}">
                                        <span class="sr-only">Cambiar estado del equipo</span>
                                        <span 
                                            class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $device->status === 'Activo' ? 'translate-x-0' : ($device->status === 'En reparacion' ? 'translate-x-5' : 'translate-x-10') }}">
                                            <!-- Icono Activo -->
                                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity {{ $device->status === 'Activo' ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out' }}">
                                                <svg class="h-3 w-3 text-emerald-600" fill="currentColor" viewBox="0 0 12 12"><path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" /></svg>
                                            </span>
                                            <!-- Icono Reparacion -->
                                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity {{ $device->status === 'En reparacion' ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out' }}">
                                                <svg class="h-3 w-3 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" /></svg>
                                            </span>
                                            <!-- Icono De Baja -->
                                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity {{ $device->status === 'De baja' ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out' }}">
                                                <svg class="h-3 w-3 text-gray-500" fill="none" viewBox="0 0 12 12"><path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                            </span>
                                        </span>
                                    </button>
                                    <span class="ml-3 text-xs font-bold text-suraki-secondary w-20">
                                        {{ $device->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('inventory.edit', $device->id) }}" wire:navigate class="text-gray-400 hover:text-suraki-primary transition-colors p-1.5 border border-gray-200 rounded-md hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <button wire:click="deleteEquipo({{ $device->id }})" wire:confirm="¿Seguro que deseas eliminar este equipo?" class="text-gray-400 hover:text-red-500 transition-colors p-1.5 border border-gray-200 rounded-md hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $devices->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
