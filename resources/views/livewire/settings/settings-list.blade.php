<div class="py-12 animate-fade-in">
    <div class="max-w-[1600px] w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-2xl border border-white/50 mb-6 p-8">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Configuración del Sistema</h2>
            <p class="mt-2 text-sm text-gray-600">Administra las sucursales y departamentos de la empresa.</p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-sm sm:rounded-2xl border border-white/50 p-6">
            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button wire:click="setTab('departments')" class="{{ $activeTab === 'departments' ? 'border-suraki-primary text-suraki-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Departamentos
                    </button>
                    <button wire:click="setTab('branches')" class="{{ $activeTab === 'branches' ? 'border-suraki-primary text-suraki-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Sucursales
                    </button>
                    <button wire:click="setTab('updates')" class="{{ $activeTab === 'updates' ? 'border-suraki-primary text-suraki-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Actualizar Sistema (ZIP)
                    </button>
                </nav>
            </div>

            <!-- Contenido Departamentos -->
            @if($activeTab === 'departments')
            <div>
                <div class="flex justify-end mb-4">
                    <x-btn-panel wire:click="openDepartmentModal">
                        + Añadir Departamento
                    </x-btn-panel>
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
                        @foreach($departments as $d)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $d->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->users_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->devices_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openDepartmentModal({{ $d->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                                <button @click="$dispatch('open-confirmation', {
                                    title: '¿Eliminar departamento?',
                                    message: 'Esta acción es irreversible y eliminará el departamento de forma permanente. Solo se completará si no tiene registros asociados.',
                                    confirmText: 'Eliminar departamento',
                                    action: () => @this.deleteDepartment({{ $d->id }})
                                })" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold focus:outline-none">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Contenido Sucursales -->
            @if($activeTab === 'branches')
            <div>
                <div class="flex justify-end mb-4">
                    <x-btn-panel wire:click="openBranchModal">
                        + Añadir Sucursal
                    </x-btn-panel>
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
                        @foreach($branches as $s)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $s->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->devices_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($s->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activa</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactiva</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openBranchModal({{ $s->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                                <button @click="$dispatch('open-confirmation', {
                                    title: '¿Eliminar sucursal?',
                                    message: 'Esta acción es irreversible y eliminará la sucursal de forma permanente. Solo se completará si no tiene registros asociados.',
                                    confirmText: 'Eliminar sucursal',
                                    action: () => @this.deleteBranch({{ $s->id }})
                                })" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold focus:outline-none">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Contenido Actualizaciones ZIP y Respaldos -->
            @if($activeTab === 'updates')
            <div>
                <!-- Banner Alerta de Emergencia -->
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-4 shadow-sm">
                    <div class="p-2 bg-amber-100 rounded-xl text-amber-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900">Panel de Recuperación de Emergencia (Standalone)</h4>
                        <p class="text-xs text-amber-700 mt-1">
                            Si el sistema sufre una caída severa o error fatal (pantalla blanca/error 500) y no puedes entrar a la web, puedes ingresar a:
                            <a href="{{ url('/safe_deploy.php') }}" target="_blank" class="font-bold underline hover:text-amber-900 ml-1">{{ url('/safe_deploy.php') }}</a>
                            (funciona de forma independiente fuera del sistema).
                        </p>
                    </div>
                </div>

                @if($deployMessage)
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium flex items-center justify-between shadow-sm">
                        <span>{{ $deployMessage }}</span>
                    </div>
                @endif

                @if($deployError)
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-medium flex items-center justify-between shadow-sm">
                        <span>{{ $deployError }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Columna 1: Carga de ZIP -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                Cargar Paquete de Actualización (.ZIP)
                            </h3>
                            <p class="text-xs text-slate-600 mb-6">
                                Sube el paquete <code>actualizacion_suraki_helpdesk.zip</code>. Se creará un respaldo automático antes de instalar los archivos y ejecutar las migraciones.
                            </p>

                            <form wire:submit.prevent="processDeploy" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Seleccionar archivo ZIP:</label>
                                    <input type="file" wire:model="zip_file" accept=".zip" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                    <x-input-error :messages="$errors->get('zip_file')" class="mt-2" />
                                </div>

                                <div wire:loading wire:target="zip_file" class="text-xs text-indigo-600 font-medium">
                                    Subiendo archivo al servidor...
                                </div>

                                <div class="pt-2">
                                    <x-btn-panel type="submit" class="w-full justify-center" wire:loading.attr="disabled" wire:target="processDeploy">
                                        <span wire:loading.remove wire:target="processDeploy">Procesar e Instalar Actualización</span>
                                        <span wire:loading wire:target="processDeploy">Procesando e Instalando...</span>
                                    </x-btn-panel>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Columna 2: Historial de Respaldos y Restauración -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Respaldos Disponibles
                                    </h3>
                                    <p class="text-xs text-slate-500">Puntos de restauración guardados en el servidor.</p>
                                </div>

                                <button wire:click="createManualBackup" wire:loading.attr="disabled" type="button" class="px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-xl border border-emerald-200 transition-colors flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    <span>Generar Respaldo Ahora</span>
                                </button>
                            </div>

                            <div class="space-y-3 max-h-[320px] overflow-y-auto pr-1 custom-scrollbar">
                                @forelse($backups ?? [] as $b)
                                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between gap-3 text-xs">
                                        <div class="min-w-0 flex-1">
                                            <p class="font-bold text-slate-800 truncate" title="{{ $b['filename'] }}">{{ $b['filename'] }}</p>
                                            <p class="text-slate-400 text-[11px] mt-0.5">{{ $b['created_at'] }} &bull; <span class="font-medium text-slate-600">{{ $b['size'] }}</span></p>
                                        </div>
                                        <button @click="$dispatch('open-confirmation', {
                                            title: '¿Restaurar este respaldo?',
                                            message: 'El sistema regresará al estado guardado en {{ $b['filename'] }}. Se creará un respaldo de seguridad antes de continuar.',
                                            confirmText: 'Restaurar Sistema Ahora',
                                            action: () => @this.restoreBackup('{{ $b['filename'] }}')
                                        })" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition-colors whitespace-nowrap">
                                            Restaurar
                                        </button>
                                    </div>
                                @empty
                                    <div class="py-8 text-center text-slate-400 text-xs border border-dashed rounded-xl">
                                        No hay respaldos guardados aún.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Configuración del Bot de Telegram -->
                <div class="mt-8 bg-sky-50/70 border border-sky-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-sky-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-sky-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.02-1.96 1.25-5.54 3.69-.52.36-1 .53-1.42.52-.47-.01-1.37-.26-2.03-.48-.82-.27-1.47-.42-1.42-.88.03-.24.37-.49 1.02-.75 3.99-1.74 6.66-2.89 8.01-3.45 3.82-1.59 4.61-1.87 5.13-1.88.11 0 .37.03.54.18.14.12.18.28.2.45-.02.07-.02.13-.03.24z"/></svg>
                                Integración con Telegram Bot (@Report_Suraki_IT_Bot)
                            </h3>
                            <p class="text-xs text-sky-700 mt-1">Recibe notificaciones automáticas con los detalles de cada ticket creado o resuelto en tu grupo de Telegram.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase text-sky-800 mb-1">Telegram Chat ID (del Grupo o Canal):</label>
                            <input type="text" wire:model="telegram_chat_id" placeholder="Ejemplo: -100123456789 o @tu_grupo" class="w-full text-xs px-4 py-2.5 bg-white border border-sky-300 rounded-xl focus:ring-2 focus:ring-sky-500 text-slate-800 font-mono">
                            <span class="text-[11px] text-sky-600 mt-1 block">Asegúrate de haber agregado al bot <code>@Report_Suraki_IT_Bot</code> como administrador a tu grupo.</span>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="saveTelegramConfig" type="button" class="flex-1 px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                                Guardar Chat ID
                            </button>
                            <button wire:click="sendTelegramTest" type="button" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors whitespace-nowrap">
                                🧪 Probar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modals -->
    @if($showDepartmentModal)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeDepartmentModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        {{ $department_id ? 'Editar Departamento' : 'Nuevo Departamento' }}
                    </h3>
                    <div class="mt-4">
                        <x-input-label for="department_name" value="Nombre" />
                        <x-text-input wire:model="department_name" id="department_name" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('department_name')" class="mt-2" />
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:gap-3">
                    <x-btn-panel wire:click="saveDepartment" class="w-full sm:w-auto">Guardar</x-btn-panel>
                    <x-secondary-button wire:click="closeDepartmentModal" class="w-full sm:w-auto mt-3 sm:mt-0">Cancelar</x-secondary-button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showBranchModal)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeBranchModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        {{ $branch_id ? 'Editar Sucursal' : 'Nueva Sucursal' }}
                    </h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <x-input-label for="branch_name" value="Nombre" />
                            <x-text-input wire:model="branch_name" id="branch_name" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('branch_name')" class="mt-2" />
                        </div>
                        <div class="flex items-center">
                            <input wire:model="branch_is_active" id="branch_is_active" type="checkbox" class="rounded border-gray-300 text-suraki-primary shadow-sm focus:ring-suraki-primary">
                            <label for="branch_is_active" class="ml-2 block text-sm text-gray-900">Activa</label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:gap-3">
                    <x-btn-panel wire:click="saveBranch" class="w-full sm:w-auto">Guardar</x-btn-panel>
                    <x-secondary-button wire:click="closeBranchModal" class="w-full sm:w-auto mt-3 sm:mt-0">Cancelar</x-secondary-button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
