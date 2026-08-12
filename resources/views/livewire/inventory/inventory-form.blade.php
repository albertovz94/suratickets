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

                    <!-- Especificaciones Dinámicas -->
                    @if(in_array($type, ['Laptop', 'Desktop', 'Servidor']))
                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- RAM -->
                            <div>
                                <x-input-label for="ram" :value="__('Memoria RAM')" />
                                <select wire:model="ram" id="ram" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                                    <option value="">Seleccionar...</option>
                                    <option value="4GB">4GB</option>
                                    <option value="8GB">8GB</option>
                                    <option value="12GB">12GB</option>
                                    <option value="16GB">16GB</option>
                                    <option value="24GB">24GB</option>
                                    <option value="32GB">32GB</option>
                                    <option value="64GB">64GB</option>
                                    <option value="128GB">128GB</option>
                                </select>
                                <x-input-error :messages="$errors->get('ram')" class="mt-2" />
                            </div>

                            <!-- CPU -->
                            <div>
                                <x-input-label for="cpu" :value="__('Procesador')" />
                                <select wire:model="cpu" id="cpu" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                                    <option value="">Seleccionar...</option>
                                    <optgroup label="Intel">
                                        <option value="Intel Celeron">Intel Celeron</option>
                                        <option value="Intel Pentium">Intel Pentium</option>
                                        <option value="Intel Core i3">Intel Core i3</option>
                                        <option value="Intel Core i5">Intel Core i5</option>
                                        <option value="Intel Core i7">Intel Core i7</option>
                                        <option value="Intel Core i9">Intel Core i9</option>
                                        <option value="Intel Xeon">Intel Xeon</option>
                                    </optgroup>
                                    <optgroup label="AMD">
                                        <option value="AMD Athlon">AMD Athlon</option>
                                        <option value="AMD Ryzen 3">AMD Ryzen 3</option>
                                        <option value="AMD Ryzen 5">AMD Ryzen 5</option>
                                        <option value="AMD Ryzen 7">AMD Ryzen 7</option>
                                        <option value="AMD Ryzen 9">AMD Ryzen 9</option>
                                        <option value="AMD Threadripper">AMD Threadripper</option>
                                        <option value="AMD EPYC">AMD EPYC</option>
                                    </optgroup>
                                    <optgroup label="Apple">
                                        <option value="Apple M1">Apple M1</option>
                                        <option value="Apple M2">Apple M2</option>
                                        <option value="Apple M3">Apple M3</option>
                                    </optgroup>
                                </select>
                                <x-input-error :messages="$errors->get('cpu')" class="mt-2" />
                            </div>

                            <!-- Generación -->
                            <div>
                                <x-input-label for="cpu_generation" :value="__('Generación')" />
                                <select wire:model="cpu_generation" id="cpu_generation" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                                    <option value="">Seleccionar...</option>
                                    <option value="Dual Core">Dual Core / Quad Core</option>
                                    @for($i=1; $i<=14; $i++)
                                        <option value="{{ $i }}a Gen">{{ $i }}a Gen (Intel)</option>
                                    @endfor
                                    <option value="Serie 1000">Serie 1000 (Ryzen)</option>
                                    <option value="Serie 2000">Serie 2000 (Ryzen)</option>
                                    <option value="Serie 3000">Serie 3000 (Ryzen)</option>
                                    <option value="Serie 4000">Serie 4000 (Ryzen)</option>
                                    <option value="Serie 5000">Serie 5000 (Ryzen)</option>
                                    <option value="Serie 6000">Serie 6000 (Ryzen)</option>
                                    <option value="Serie 7000">Serie 7000 (Ryzen)</option>
                                    <option value="Serie 8000">Serie 8000 (Ryzen)</option>
                                    <option value="Pro/Max/Ultra">Pro/Max/Ultra (Apple)</option>
                                </select>
                                <x-input-error :messages="$errors->get('cpu_generation')" class="mt-2" />
                            </div>

                            <!-- Almacenamiento -->
                            <div>
                                <x-input-label for="storage" :value="__('Disco Duro')" />
                                <select wire:model="storage" id="storage" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
                                    <option value="">Seleccionar...</option>
                                    <optgroup label="Estado Sólido (SSD)">
                                        <option value="120GB SSD">120GB SSD</option>
                                        <option value="240GB SSD">240GB SSD</option>
                                        <option value="256GB SSD">256GB SSD</option>
                                        <option value="480GB SSD">480GB SSD</option>
                                        <option value="500GB SSD">500GB SSD</option>
                                        <option value="512GB SSD">512GB SSD</option>
                                        <option value="1TB SSD">1TB SSD</option>
                                        <option value="2TB SSD">2TB SSD</option>
                                        <option value="4TB SSD">4TB SSD</option>
                                    </optgroup>
                                    <optgroup label="Disco Mecánico (HDD)">
                                        <option value="500GB HDD">500GB HDD</option>
                                        <option value="1TB HDD">1TB HDD</option>
                                        <option value="2TB HDD">2TB HDD</option>
                                        <option value="4TB HDD">4TB HDD</option>
                                        <option value="5TB HDD">5TB HDD</option>
                                    </optgroup>
                                </select>
                                <x-input-error :messages="$errors->get('storage')" class="mt-2" />
                            </div>
                        </div>
                    @else
                        <!-- Especificaciones Clásicas -->
                        <div class="md:col-span-2">
                            <x-input-label for="specs" :value="__('Especificaciones (Tóner, Puertos, Modelo, etc.)')" />
                            <x-text-input wire:model="specs" id="specs" class="block mt-1 w-full bg-white/50" type="text" />
                            <x-input-error :messages="$errors->get('specs')" class="mt-2" />
                        </div>
                    @endif

                    <!-- Tipo -->
                    <div>
                        <x-input-label for="type" :value="__('Tipo de Equipo')" />
                        <select wire:model.live="type" id="type" class="block mt-1 w-full border-gray-300 focus:border-suraki-primary focus:ring-suraki-primary rounded-xl shadow-sm bg-white/50">
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

                    <!-- Código QR -->
                    <div class="md:col-span-2">
                        <x-input-label for="qr_code" :value="__('Código QR del Equipo')" />
                        
                        <div class="mt-2 flex flex-col justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-white/50 hover:bg-white/80 transition-colors duration-200"
                             x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            
                            <div class="space-y-1 text-center w-full">
                                @if ($qr_code)
                                    <div class="mb-4">
                                        <img src="{{ $qr_code->temporaryUrl() }}" class="mx-auto h-32 w-32 object-contain rounded-md shadow-sm border border-gray-200">
                                        <p class="text-xs text-green-600 mt-2 font-medium">Previsualización del código QR</p>
                                    </div>
                                @elseif ($existing_qr_code_path)
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $existing_qr_code_path) }}" class="mx-auto h-32 w-32 object-contain rounded-md shadow-sm border border-gray-200">
                                        <p class="text-xs text-gray-500 mt-2 font-medium">Código QR actual</p>
                                    </div>
                                @else
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                @endif

                                <div class="flex text-sm text-gray-600 justify-center w-full">
                                    <label for="qr_code" class="relative cursor-pointer rounded-md font-medium text-suraki-primary hover:text-suraki-secondary focus-within:outline-none transition-colors">
                                        <span>Sube un archivo</span>
                                        <input id="qr_code" wire:model="qr_code" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp">
                                    </label>
                                    <p class="pl-1">o arrastra y suelta aquí</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, WEBP hasta 2MB
                                </p>
                            </div>
                            
                            <!-- Barra de progreso -->
                            <div x-show="isUploading" class="w-full mt-4 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-suraki-primary h-2.5 rounded-full transition-all duration-300" x-bind:style="'width: ' + progress + '%'"></div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('qr_code')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <x-secondary-button href="{{ route('inventory.index') }}" wire:navigate>
                        Cancelar
                    </x-secondary-button>
                    <x-btn-panel type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto" style="min-width: 200px;">
                        {{ __('Guardar Equipo') }}
                    </x-btn-panel>
                </div>
            </form>
        </div>
    </div>
</div>
