<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('horarios.index') }}" wire:navigate class="p-2 text-gray-400 hover:text-suraki-primary bg-white rounded-xl shadow-sm border border-gray-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Control Outsourcing (Check-In)</h2>
            <p class="text-sm text-gray-500">Programa turnos o registra tu asistencia diaria si eres outsourcing.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 flex items-center gap-2 border border-green-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Panel Izquierdo: Agendar Turno (Para Admin o para que ellos mismos avisen que vienen) -->
        <div class="lg:col-span-1">
            <form wire:submit="createShift" class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-6 space-y-4">
                <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Programar Asistencia</h3>
                
                @if(auth()->user()->rol === 'admin')
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Usuario Outsourcing</label>
                        <select wire:model="user_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 text-sm" required>
                            <option value="">Seleccione...</option>
                            @foreach($outsourcing_users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Fecha</label>
                    <input type="date" wire:model="date" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 text-sm" required>
                    @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Hora Inicio (Opcional)</label>
                        <input type="time" wire:model="scheduled_start" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 text-sm">
                        @error('scheduled_start') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Hora Fin (Opcional)</label>
                        <input type="time" wire:model="scheduled_end" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 text-sm">
                        @error('scheduled_end') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-gray-900 hover:bg-gray-800 text-white font-bold py-2.5 rounded-xl shadow-sm transition-all text-sm">
                    Añadir a la Agenda
                </button>
            </form>
        </div>

        <!-- Panel Derecho: Tabla de Turnos y Botones de Check-in -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-900 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Fecha</th>
                                @if(auth()->user()->rol === 'admin')
                                    <th class="px-6 py-4 font-bold">Outsourcing</th>
                                @endif
                                <th class="px-6 py-4 font-bold">Agendado</th>
                                <th class="px-6 py-4 font-bold text-center">Estado / Check In</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse($shifts as $shift)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ $shift->date->format('d/m/Y') }}
                                        @if($shift->date->isToday())
                                            <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">HOY</span>
                                        @endif
                                    </td>
                                    @if(auth()->user()->rol === 'admin')
                                        <td class="px-6 py-4 font-medium">{{ $shift->user->name ?? 'N/A' }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-xs text-gray-500">
                                        @if($shift->scheduled_start && $shift->scheduled_end)
                                            {{ \Carbon\Carbon::parse($shift->scheduled_start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($shift->scheduled_end)->format('h:i A') }}
                                        @else
                                            <span class="italic">Sin hora específica</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($shift->status === 'programado')
                                            @if($shift->date->isToday() || auth()->user()->rol === 'admin')
                                                <button wire:click="checkIn({{ $shift->id }})" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded-lg font-bold text-xs shadow-sm flex items-center gap-1 mx-auto transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                                    CHECK-IN LLEGADA
                                                </button>
                                            @else
                                                <span class="text-xs font-bold text-gray-400">PENDIENTE</span>
                                            @endif
                                        @elseif($shift->status === 'en_curso')
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="text-xs text-green-600 font-bold">En turno desde {{ $shift->check_in->format('h:i A') }}</span>
                                                <button wire:click="checkOut({{ $shift->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg font-bold text-xs shadow-sm flex items-center gap-1 mx-auto transition-colors mt-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                    CHECK-OUT SALIDA
                                                </button>
                                            </div>
                                        @elseif($shift->status === 'completado')
                                            <div class="bg-gray-100 text-gray-600 text-xs px-3 py-1.5 rounded-lg inline-block font-medium">
                                                Completado ({{ $shift->check_in->format('h:i A') }} - {{ $shift->check_out->format('h:i A') }})
                                            </div>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-lg uppercase">{{ $shift->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        No hay turnos de outsourcing registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $shifts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
