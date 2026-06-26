<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('schedules.index') }}" wire:navigate class="p-2 text-gray-400 hover:text-suraki-primary bg-white rounded-xl shadow-sm border border-gray-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Configuración de Horarios</h2>
            <p class="text-sm text-gray-500">Asigna esquemas fijos u outsourcing al personal de Sistemas.</p>
        </div>
    </div>

    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-6 md:p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="user_id" class="block text-sm font-bold text-gray-700 mb-2">Usuario</label>
                <select wire:model.live="user_id" id="user_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 focus:bg-white transition-colors" required>
                    <option value="">Selecciona un usuario...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="type" class="block text-sm font-bold text-gray-700 mb-2">Tipo de Contrato / Horario</label>
                <select wire:model.live="type" id="type" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 focus:bg-white transition-colors" required>
                    <option value="fijo">Interno (Horario Fijo Semanal)</option>
                    <option value="outsourcing">Outsourcing (Horario Flexible / Por Turno)</option>
                </select>
                @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        @if($type === 'fijo')
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Horario Semanal</h3>
                <p class="text-sm text-gray-500 mb-6">Deja en blanco los días que sean libres.</p>

                <div class="space-y-4">
                    @php
                        $days = [
                            'monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles',
                            'thursday' => 'Jueves', 'friday' => 'Viernes', 'saturday' => 'Sábado', 'sunday' => 'Domingo'
                        ];
                    @endphp

                    @foreach($days as $key => $label)
                        <div x-data="{ 
                                start: '{{ $schedule[$key]['start'] ?? '' }}', 
                                end: '{{ $schedule[$key]['end'] ?? '' }}' 
                            }"
                            class="flex items-center gap-4 p-4 rounded-xl transition-all duration-300"
                            :class="(start || end) ? 'bg-blue-50 border border-blue-200 shadow-sm' : 'bg-gray-50 border border-gray-200 opacity-80'">
                            
                            <div class="w-24">
                                <div class="font-bold text-gray-700" :class="(start || end) ? 'text-gray-900' : 'text-gray-500'">{{ $label }}</div>
                                <div x-show="!start && !end" class="text-[10px] font-bold text-red-500 uppercase mt-1 tracking-wider bg-red-100 inline-block px-2 py-0.5 rounded-full">Libre</div>
                                <div x-show="start || end" class="text-[10px] font-bold text-green-600 uppercase mt-1 tracking-wider bg-green-100 inline-block px-2 py-0.5 rounded-full" style="display: none;">Laboral</div>
                            </div>
                            
                            <div class="flex-1 grid grid-cols-2 gap-4" :class="(!start && !end) ? 'opacity-70 focus-within:opacity-100 transition-opacity' : ''">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Entrada</label>
                                    <input type="time" wire:model="schedule.{{ $key }}.start" x-on:change="start = $event.target.value" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary text-sm bg-white transition-colors cursor-pointer" :class="!start ? 'text-gray-400' : 'text-gray-900'">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Salida</label>
                                    <input type="time" wire:model="schedule.{{ $key }}.end" x-on:change="end = $event.target.value" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary text-sm bg-white transition-colors cursor-pointer" :class="!end ? 'text-gray-400' : 'text-gray-900'">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="border-t border-gray-200 pt-6 mt-6">
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-6 h-6 text-purple-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-bold text-purple-900">Configuración Flexible</h4>
                        <p class="text-sm text-purple-700 mt-1">El personal de Outsourcing no usa un horario fijo. Para ellos, utiliza el panel de <strong>Control Outsourcing</strong> donde podrán hacer Check-In o agendar turnos específicos según el día.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-8 flex justify-end">
            <x-btn-panel type="submit" class="w-full sm:w-auto">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Guardar Configuración
            </x-btn-panel>
        </div>
    </form>
</div>
