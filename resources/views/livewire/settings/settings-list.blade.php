<div class="py-12 animate-fade-in">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-2xl border border-white/50 mb-6 p-8">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Configuración del Sistema</h2>
            <p class="mt-2 text-sm text-gray-600">Administra las sucursales y departamentos de la empresa.</p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-2xl border border-white/50 p-6">
            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button wire:click="setTab('departamentos')" class="{{ $activeTab === 'departamentos' ? 'border-[#ff5a5f] text-[#ff5a5f]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Departamentos
                    </button>
                    <button wire:click="setTab('sucursales')" class="{{ $activeTab === 'sucursales' ? 'border-[#ff5a5f] text-[#ff5a5f]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Sucursales
                    </button>
                </nav>
            </div>

            <!-- Contenido Departamentos -->
            @if($activeTab === 'departamentos')
            <div>
                <div class="flex justify-end mb-4">
                    <button wire:click="openDeptoModal" class="px-4 py-2 bg-[#ff5a5f] hover:bg-[#e0484d] text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                        + Nuevo Departamento
                    </button>
                </div>
                
                <table class="min-w-full divide-y divide-gray-200 border rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Usuarios</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Equipos</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($departamentos as $d)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $d->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->users_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->equipos_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openDeptoModal({{ $d->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                                <button wire:click="deleteDepto({{ $d->id }})" wire:confirm="¿Seguro que deseas eliminar?" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Contenido Sucursales -->
            @if($activeTab === 'sucursales')
            <div>
                <div class="flex justify-end mb-4">
                    <button wire:click="openSucursalModal" class="px-4 py-2 bg-[#ff5a5f] hover:bg-[#e0484d] text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                        + Nueva Sucursal
                    </button>
                </div>
                
                <table class="min-w-full divide-y divide-gray-200 border rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Equipos</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($sucursales as $s)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $s->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->equipos_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($s->activa)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activa</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactiva</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openSucursalModal({{ $s->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                                <button wire:click="deleteSucursal({{ $s->id }})" wire:confirm="¿Seguro que deseas eliminar?" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Modals -->
    @if($showDeptoModal)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeDeptoModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        {{ $depto_id ? 'Editar Departamento' : 'Nuevo Departamento' }}
                    </h3>
                    <div class="mt-4">
                        <x-input-label for="depto_nombre" value="Nombre" />
                        <x-text-input wire:model="depto_nombre" id="depto_nombre" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('depto_nombre')" class="mt-2" />
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="saveDepto" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#ff5a5f] text-base font-medium text-white hover:bg-[#e0484d] sm:ml-3 sm:w-auto sm:text-sm">Guardar</button>
                    <button wire:click="closeDeptoModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showSucursalModal)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeSucursalModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        {{ $sucursal_id ? 'Editar Sucursal' : 'Nueva Sucursal' }}
                    </h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <x-input-label for="sucursal_nombre" value="Nombre" />
                            <x-text-input wire:model="sucursal_nombre" id="sucursal_nombre" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('sucursal_nombre')" class="mt-2" />
                        </div>
                        <div class="flex items-center">
                            <input wire:model="sucursal_activa" id="sucursal_activa" type="checkbox" class="rounded border-gray-300 text-suraki-primary shadow-sm focus:ring-suraki-primary">
                            <label for="sucursal_activa" class="ml-2 block text-sm text-gray-900">Activa</label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="saveSucursal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#ff5a5f] text-base font-medium text-white hover:bg-[#e0484d] sm:ml-3 sm:w-auto sm:text-sm">Guardar</button>
                    <button wire:click="closeSucursalModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
