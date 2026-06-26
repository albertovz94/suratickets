<div class="max-w-4xl mx-auto space-y-6 pb-12">
    <div class="flex items-center gap-4">
        <a href="{{ route('requests.index') }}" wire:navigate class="p-2 text-gray-400 hover:text-suraki-primary bg-white rounded-xl shadow-sm border border-gray-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nueva Solicitud de Equipo / IT</h2>
            <p class="text-sm text-gray-500">Asistente paso a paso para procesar tu requerimiento.</p>
        </div>
    </div>

    <!-- Stepper Indicator -->
    <div class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-6">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-100 rounded-full"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-suraki-primary rounded-full transition-all duration-500" style="width: {{ ($step - 1) * 33.33 }}%;"></div>
            
            @foreach([1 => 'Categoría', 2 => 'Asignación', 3 => 'Justificación', 4 => 'Revisión'] as $num => $label)
            <div class="relative z-10 flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 {{ $step >= $num ? 'bg-suraki-primary text-white shadow-md' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                    {{ $num }}
                </div>
                <span class="text-xs font-semibold {{ $step >= $num ? 'text-suraki-primary' : 'text-gray-400' }}">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-6 md:p-8 space-y-8">
        
        @if($step == 1)
        <!-- PASO 1: CATEGORÍA Y URGENCIA -->
        <div class="space-y-8 animate-fade-in-up">
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">1. ¿Qué tipo de solicitud necesitas realizar?</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @php
                        $categories = [
                            'Computadoras' => '💻',
                            'Periféricos (Teclado, Ratón, Monitor)' => '🖱️',
                            'Energía (UPS, Baterías)' => '🔋',
                            'Redes e Internet' => '🌐',
                            'Software e Instalación' => '💿',
                            'Desarrollo Web / Meta' => '🌍',
                            'Cambio de Sede' => '🏢',
                            'Otros' => '📦',
                        ];
                    @endphp
                    @foreach($categories as $name => $icon)
                    <label class="cursor-pointer">
                        <input type="radio" name="device_type" wire:model.live="device_type" value="{{ $name }}" class="peer sr-only">
                        <div class="rounded-xl border-2 border-gray-100 p-4 hover:border-suraki-primary/50 peer-checked:border-suraki-primary peer-checked:bg-suraki-primary/5 transition-all text-center h-full flex flex-col items-center justify-center gap-2">
                            <span class="text-3xl">{{ $icon }}</span>
                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-suraki-primary">{{ $name }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('device_type') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Nivel de Urgencia</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['baja' => 'Baja', 'media' => 'Media', 'alta' => 'Alta', 'critica' => 'Crítica'] as $val => $label)
                    <label class="cursor-pointer">
                        <input type="radio" name="urgency" wire:model.live="urgency" value="{{ $val }}" class="peer sr-only">
                        <div class="rounded-xl border-2 border-gray-100 py-3 px-4 text-center hover:border-suraki-primary/50 peer-checked:border-suraki-primary peer-checked:bg-suraki-primary peer-checked:text-white transition-all font-bold text-gray-600">
                            {{ $label }}
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('urgency') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
            </div>
        </div>
        @endif

        @if($step == 2)
        <!-- PASO 2: ASIGNACIÓN OUTSOURCING -->
        <div class="space-y-6 animate-fade-in-up">
            <h3 class="text-lg font-bold text-gray-800">2. ¿A qué técnico deseas asignar esta solicitud?</h3>
            <p class="text-sm text-gray-500 mb-4">Selecciona un miembro del equipo de Outsourcing para atender tu solicitud.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($outsourcingUsers as $user)
                <label class="cursor-pointer">
                    <input type="radio" name="assigned_to" wire:model.live="assigned_to" value="{{ $user->id }}" class="peer sr-only">
                    <div class="rounded-xl border-2 border-gray-100 p-4 hover:border-suraki-primary/50 peer-checked:border-suraki-primary peer-checked:bg-suraki-primary/5 transition-all h-full flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold shrink-0">
                            {{ substr($user->name, 0, 1) }}{{ substr($user->last_name ?? '', 0, 1) }}
                        </div>
                        <div>
                            <span class="block font-bold text-gray-800 peer-checked:text-suraki-primary">{{ $user->name }} {{ $user->last_name }}</span>
                            <span class="block text-xs text-gray-500">Técnico Outsourcing</span>
                        </div>
                    </div>
                </label>
                @empty
                <div class="col-span-full bg-yellow-50 text-yellow-700 p-4 rounded-xl border border-yellow-200">
                    No hay técnicos Outsourcing registrados en el sistema.
                </div>
                @endforelse
            </div>
            @error('assigned_to') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
        </div>
        @endif

        @if($step == 3)
        <!-- PASO 3: JUSTIFICACIÓN -->
        <div class="space-y-6 animate-fade-in-up">
            <h3 class="text-lg font-bold text-gray-800">3. Justificación y Detalles</h3>
            <p class="text-sm text-gray-500 mb-4">Explica detalladamente por qué necesitas esto y cualquier especificación técnica requerida.</p>
            
            <div>
                <textarea wire:model="description" rows="6" 
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 focus:bg-white transition-colors resize-none text-gray-700"
                    placeholder="Ej. Mi monitor actual parpadea mucho, necesito uno nuevo para poder diseñar correctamente..." required></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
        @endif

        @if($step == 4)
        <!-- PASO 4: REVISIÓN -->
        <div class="space-y-6 animate-fade-in-up">
            <h3 class="text-lg font-bold text-gray-800">4. Revisión Final</h3>
            
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 space-y-4">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Solicitante</span>
                        <div class="font-medium text-gray-800">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</div>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Departamento</span>
                        <div class="font-medium text-gray-800">{{ auth()->user()->department->name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Fecha de Solicitud</span>
                        <div class="font-medium text-gray-800">{{ \Carbon\Carbon::now()->translatedFormat('d \d\e F, Y') }}</div>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Urgencia</span>
                        <div class="font-medium text-suraki-primary capitalize">{{ $urgency }}</div>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Técnico Asignado</span>
                        <div class="font-medium text-gray-800">{{ collect($outsourcingUsers)->firstWhere('id', $assigned_to)?->name ?? 'N/A' }}</div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase mb-1">Requerimiento</span>
                    <div class="font-bold text-suraki-secondary">{{ $device_type }}</div>
                </div>

                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase mb-1">Justificación</span>
                    <p class="text-sm text-gray-600 bg-white p-4 rounded-lg border border-gray-100 whitespace-pre-wrap">{{ $description }}</p>
                </div>
            </div>
            
            <div class="bg-blue-50 border border-blue-100 text-blue-800 text-sm p-4 rounded-xl flex gap-3">
                <svg class="w-5 h-5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Al enviar esta solicitud, será evaluada por el departamento de Sistemas. Recibirás actualizaciones en la sección principal.</p>
            </div>
        </div>
        @endif

        <!-- Controles de Navegación -->
        <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
            @if($step > 1)
                <button type="button" wire:click="prevStep" class="px-6 py-2.5 rounded-xl text-gray-500 font-bold hover:bg-gray-100 transition-colors">
                    Atrás
                </button>
            @else
                <div></div> <!-- Spacer -->
            @endif

            @if($step < 4)
                <x-btn-panel wire:click="nextStep" class="w-full sm:w-auto">
                    Siguiente
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </x-btn-panel>
            @else
                <x-btn-panel type="submit" class="w-full sm:w-auto">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Enviar Solicitud
                </x-btn-panel>
            @endif
        </div>
    </form>
</div>
