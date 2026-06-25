<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-heading font-bold text-2xl text-suraki-secondary leading-tight">
                    Gestión de Usuarios
                </h2>
                <p class="text-sm text-suraki-tertiary mt-1">Administra cuentas, permisos y asignaciones de equipos</p>
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 bg-white border border-suraki-neutral-dark text-suraki-secondary rounded-lg text-sm font-semibold hover:bg-suraki-neutral transition-colors shadow-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Exportar
                </button>
                <a href="{{ route('users.create') }}" wire:navigate class="px-4 py-2 bg-suraki-primary text-white rounded-lg text-sm font-semibold hover:bg-suraki-primary-hover transition-colors shadow-sm shadow-suraki-primary/20 inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuevo Usuario
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[1600px] w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Usuarios Activos -->
                <div class="card-suraki p-6 flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold font-mono text-suraki-secondary">{{ $stats['total_activos'] }}</p>
                        <p class="text-sm font-medium text-suraki-tertiary mt-1">Usuarios Activos</p>
                        <span class="inline-block mt-3 px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md border border-green-200">
                            Activos
                        </span>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Administradores -->
                <div class="card-suraki p-6 flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold font-mono text-suraki-secondary">{{ $stats['total_admins'] }}</p>
                        <p class="text-sm font-medium text-suraki-tertiary mt-1">Administradores</p>
                        <span class="inline-block mt-3 px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md border border-green-200">
                            Acceso total
                        </span>
                    </div>
                    <div class="p-3 bg-red-50 rounded-xl text-suraki-primary">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                </div>

                <!-- Cuentas Bloqueadas -->
                <div class="card-suraki p-6 flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold font-mono text-suraki-secondary">{{ $stats['total_bloqueadas'] }}</p>
                        <p class="text-sm font-medium text-suraki-tertiary mt-1">Cuentas Bloqueadas</p>
                        <span class="inline-block mt-3 px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-md border border-orange-200">
                            Revisar
                        </span>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                </div>

                <!-- Sin Equipo Asignado -->
                <div class="card-suraki p-6 flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold font-mono text-suraki-secondary">{{ $stats['sin_equipo'] }}</p>
                        <p class="text-sm font-medium text-suraki-tertiary mt-1">Sin Equipo Asignado</p>
                        <span class="inline-block mt-3 px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-md border border-blue-200">
                            Pendiente
                        </span>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>
                    </div>
                </div>
            </div>



            <!-- Filters -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="w-full md:w-1/3 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-suraki-tertiary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-suraki-neutral-dark rounded-lg leading-5 bg-white placeholder-suraki-tertiary focus:outline-none focus:ring-1 focus:ring-suraki-primary focus:border-suraki-primary sm:text-sm transition duration-150 ease-in-out" placeholder="Buscar por nombre, email, departamento...">
                </div>
                
                <div class="w-full md:w-auto flex flex-wrap gap-3">
                    <select wire:model.live="roleFilter" class="border-suraki-neutral-dark rounded-lg text-sm text-suraki-secondary focus:ring-suraki-primary focus:border-suraki-primary shadow-sm py-2">
                        <option value="">Todos los roles</option>
                        <option value="admin">Administrador</option>
                        <option value="outsourcing">Outsourcing</option>
                        <option value="usuario">Usuario</option>
                    </select>

                    <select wire:model.live="statusFilter" class="border-suraki-neutral-dark rounded-lg text-sm text-suraki-secondary focus:ring-suraki-primary focus:border-suraki-primary shadow-sm py-2">
                        <option value="">Todos los estados</option>
                        <option value="Activo">Activo</option>
                        <option value="Bloqueada">Bloqueada</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>

                    <select wire:model.live="departmentFilter" class="border-suraki-neutral-dark rounded-lg text-sm text-suraki-secondary focus:ring-suraki-primary focus:border-suraki-primary shadow-sm py-2">
                        <option value="">Todos los departamentos</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="card-suraki p-0 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-suraki-neutral/50 border-b border-suraki-neutral text-xs font-bold text-suraki-tertiary uppercase tracking-wider">
                                <th class="px-6 py-4 w-10">
                                    <input type="checkbox" class="rounded border-gray-300 text-suraki-primary focus:ring-suraki-primary">
                                </th>
                                <th class="px-6 py-4">Usuario</th>
                                <th class="px-6 py-4">Correo / Usuario</th>
                                <th class="px-6 py-4">Rol</th>
                                <th class="px-6 py-4">Sucursal</th>
                                <th class="px-6 py-4">Departamento</th>
                                <th class="px-6 py-4">Estado</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-suraki-neutral">
                            @forelse ($users as $user)
                                <tr class="hover:bg-suraki-neutral/20 transition-colors">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" value="{{ $user->id }}" class="rounded border-gray-300 text-suraki-primary focus:ring-suraki-primary">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                // Generate color based on ID for consistent random looking avatars
                                                $colors = ['bg-red-600', 'bg-blue-600', 'bg-purple-600', 'bg-orange-600', 'bg-green-600', 'bg-gray-800'];
                                                $bgColor = $colors[$user->id % count($colors)];
                                            @endphp
                                            <div class="w-10 h-10 shrink-0 rounded-full {{ $bgColor }} text-white flex items-center justify-center font-bold text-sm shadow-sm overflow-hidden">
                                                @if($user->avatar_path)
                                                    <img src="{{ $user->avatar_path }}" class="w-full h-full object-cover" alt="Avatar">
                                                @else
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ $user->last_name ? strtoupper(substr($user->last_name, 0, 1)) : '' }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-suraki-secondary">{{ $user->name }} {{ $user->last_name }}</p>
                                                <p class="text-xs text-suraki-tertiary">{{ $user->assigned_devices_count }} equipos asignados</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-suraki-secondary">{{ $user->email }}</p>
                                        <p class="text-xs text-suraki-tertiary">{{ $user->username }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $user->hasAdminAccess() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $user->hasAdminAccess() ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-suraki-secondary">{{ optional($user->branch)->name ?? 'Sin sucursal' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-suraki-secondary">{{ optional($user->department)->name ?? 'Sin departamento' }}</p>
                                    </td>
                                    <td class="px-6 py-4 flex items-center h-[73px]">
                                        <button 
                                            wire:click="toggleUserStatus({{ $user->id }})" 
                                            type="button" 
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $user->status === 'Activo' ? 'bg-green-500' : ($user->status === 'Bloqueada' ? 'bg-orange-500' : 'bg-gray-300') }}" 
                                            role="switch" 
                                            aria-checked="{{ $user->status === 'Activo' ? 'true' : 'false' }}">
                                            <span class="sr-only">Habilitar/Deshabilitar usuario</span>
                                            <span 
                                                class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $user->status === 'Activo' ? 'translate-x-5' : 'translate-x-0' }}">
                                                <!-- Icon when OFF -->
                                                <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity {{ $user->status === 'Activo' ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in' }}" aria-hidden="true">
                                                    <svg class="h-3 w-3 {{ $user->status === 'Bloqueada' ? 'text-orange-400' : 'text-gray-400' }}" fill="none" viewBox="0 0 12 12">
                                                        <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                                <!-- Icon when ON -->
                                                <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity {{ $user->status === 'Activo' ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out' }}" aria-hidden="true">
                                                    <svg class="h-3 w-3 text-green-600" fill="currentColor" viewBox="0 0 12 12">
                                                        <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                                    </svg>
                                                </span>
                                            </span>
                                        </button>
                                        <span class="ml-3 text-xs font-bold text-suraki-secondary">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('users.edit', $user->id) }}" wire:navigate class="p-1.5 text-suraki-tertiary hover:text-suraki-secondary hover:bg-suraki-neutral rounded transition-colors" title="Editar">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>
                                            <button wire:click="deleteUser({{ $user->id }})" wire:confirm="¿Estás seguro de eliminar este usuario?" class="p-1.5 text-suraki-tertiary hover:text-suraki-primary hover:bg-red-50 rounded transition-colors" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-sm text-suraki-tertiary">
                                        No se encontraron usuarios que coincidan con la búsqueda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="p-4 border-t border-suraki-neutral">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
