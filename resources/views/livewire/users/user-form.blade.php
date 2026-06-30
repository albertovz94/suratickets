<div>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" wire:navigate class="p-2 bg-white rounded-full text-suraki-tertiary hover:text-suraki-secondary shadow-sm transition-colors border border-suraki-neutral-dark">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class="font-heading font-bold text-2xl text-suraki-secondary leading-tight">
                {{ $user_id ? 'Editar Usuario' : 'Nuevo Usuario' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card-suraki p-8">
                <form wire:submit.prevent="save" class="space-y-6">
                    
                    <div class="border-b border-suraki-neutral-dark pb-4">
                        <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Datos de la Cuenta</h3>
                        <p class="text-sm text-suraki-tertiary mt-1">Información básica y credenciales de acceso.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Avatar Section -->
                        <div class="md:col-span-2 flex items-center gap-6 mb-4">
                            <div class="flex-shrink-0">
                                @if($form->avatar)
                                    <img src="{{ $form->avatar->temporaryUrl() }}" alt="Preview" class="w-20 h-20 rounded-xl object-cover border border-suraki-neutral-dark shadow-sm">
                                @elseif($form->existing_avatar)
                                    <img src="{{ $form->existing_avatar }}" alt="Current Avatar" class="w-20 h-20 rounded-xl object-cover border border-suraki-neutral-dark shadow-sm">
                                @else
                                    <div class="w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center border border-dashed border-gray-300">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="avatar" value="Foto de Perfil" />
                                <input type="file" wire:model="form.avatar" id="avatar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors cursor-pointer" accept="image/*">
                                <p class="text-xs text-suraki-tertiary mt-1">JPG, PNG o GIF. Máximo 2MB.</p>
                                <x-input-error :messages="$errors->get('form.avatar')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="name" value="Nombres" />
                            <x-text-input wire:model="form.name" id="name" type="text" class="mt-1 block w-full" required autofocus />
                            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="last_name" value="Apellidos" />
                            <x-text-input wire:model="form.last_name" id="last_name" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('form.last_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Correo Electrónico" />
                            <x-text-input wire:model="form.email" id="email" type="email" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="username" value="Usuario (Opcional)" />
                            <x-text-input wire:model="form.username" id="username" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('form.username')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="{{ $user_id ? 'Nueva Contraseña (dejar en blanco para no cambiar)' : 'Contraseña' }}" />
                            <x-text-input wire:model="form.password" id="password" type="password" class="mt-1 block w-full" :required="!$user_id" />
                            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                        </div>
                    </div>

                    <div class="border-b border-suraki-neutral-dark pb-4 mt-8">
                        <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Permisos y Asignación</h3>
                        <p class="text-sm text-suraki-tertiary mt-1">Configura el acceso y la ubicación del usuario en la empresa.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="role" value="Rol en el Sistema" />
                            <select wire:model="form.role" id="role" class="block w-full mt-1 border-suraki-neutral-dark rounded-lg shadow-sm focus:border-suraki-primary focus:ring focus:ring-suraki-primary focus:ring-opacity-50 text-suraki-secondary transition duration-150 ease-in-out">
                                <option value="usuario">Usuario / Cliente</option>
                                <option value="admin">Administrador</option>
                                <option value="outsourcing">Outsourcing</option>
                            </select>
                            <x-input-error :messages="$errors->get('form.role')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" value="Estado de la Cuenta" />
                            <select wire:model="form.status" id="status" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm" required>
                                <option value="Activo">Activo</option>
                                <option value="Bloqueada">Bloqueada</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                            <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="branch_id" value="Sucursal" />
                            <select wire:model="form.branch_id" id="branch_id" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm" required>
                                <option value="">Seleccione Sucursal</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('form.branch_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="department_id" value="Departamento" />
                            <select wire:model="form.department_id" id="department_id" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm" required>
                                <option value="">Seleccione Departamento</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('form.department_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6">
                        <a href="{{ route('users.index') }}" wire:navigate class="text-sm font-medium text-suraki-tertiary hover:text-suraki-secondary mr-6 transition-colors">
                            Cancelar
                        </a>
                        <x-primary-button wire:loading.attr="disabled">
                            {{ $user_id ? 'Guardar Cambios' : 'Crear Usuario' }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
