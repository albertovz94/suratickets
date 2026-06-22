<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Horarios del Departamento de Sistemas</h2>
            <p class="text-sm text-gray-500">Monitorea quién está en turno y el esquema de trabajo del equipo.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('horarios.outsourcing') }}" wire:navigate class="inline-flex items-center gap-2 bg-white text-suraki-primary border border-suraki-primary hover:bg-red-50 font-bold py-2.5 px-5 rounded-xl transition-all shadow-sm">
                Control Outsourcing
            </a>
            @if(auth()->user()->rol === 'admin')
            <a href="{{ route('horarios.config') }}" wire:navigate class="inline-flex items-center gap-2 bg-suraki-primary hover:bg-suraki-secondary text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-sm">
                Configurar Horarios
            </a>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 flex items-center gap-2 border border-green-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" wire:poll.30s>
        @forelse($users as $user)
            <div class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-6 relative overflow-hidden transition-all hover:shadow-md">
                
                @if($user->is_working_now)
                    <div class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                        EN TURNO
                    </div>
                @else
                    <div class="absolute top-0 right-0 bg-gray-400 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                        LIBRE / AUSENTE
                    </div>
                @endif

                <div class="flex items-center gap-4 mb-4">
                    @if($user->avatar_path)
                        <img src="{{ $user->avatar_path }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover border-2 {{ $user->is_working_now ? 'border-green-500' : 'border-gray-200' }}">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center border-2 {{ $user->is_working_now ? 'border-green-500' : 'border-gray-200' }}">
                            <span class="text-xl font-bold text-gray-500">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $user->name }} {{ $user->last_name }}</h3>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $user->schedule && $user->schedule->type === 'outsourcing' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $user->schedule ? ucfirst($user->schedule->type) : 'Sin Horario' }}
                        </span>
                    </div>
                </div>

                <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <div class="font-semibold text-gray-800 mb-2">Horario de Hoy ({{ ucfirst(\Carbon\Carbon::now()->translatedFormat('l')) }})</div>
                    
                    @if(!$user->schedule)
                        <span class="text-gray-400">No tiene un esquema de horario asignado.</span>
                    @elseif($user->schedule->type === 'fijo')
                        @php
                            $dayOfWeek = strtolower(\Carbon\Carbon::now()->englishDayOfWeek);
                            $startField = $dayOfWeek . '_start';
                            $endField = $dayOfWeek . '_end';
                            $start = $user->schedule->$startField;
                            $end = $user->schedule->$endField;
                        @endphp
                        @if($start && $end)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-suraki-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($end)->format('h:i A') }}
                            </div>
                        @else
                            <span class="text-gray-500 font-medium">Día Libre</span>
                        @endif
                    @elseif($user->schedule->type === 'outsourcing')
                        @php
                            $todayShift = $user->workShifts->first();
                        @endphp
                        @if($todayShift)
                            @if($todayShift->status === 'programado')
                                <div class="text-yellow-600 font-medium">
                                    Programado: {{ \Carbon\Carbon::parse($todayShift->scheduled_start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($todayShift->scheduled_end)->format('h:i A') }}
                                </div>
                            @elseif($todayShift->status === 'en_curso')
                                <div class="text-green-600 font-medium">
                                    Inició: {{ $todayShift->check_in->format('h:i A') }} (En curso)
                                </div>
                            @elseif($todayShift->status === 'completado')
                                <div class="text-gray-500">
                                    Completó: {{ $todayShift->check_in->format('h:i A') }} - {{ $todayShift->check_out->format('h:i A') }}
                                </div>
                            @else
                                <span class="text-red-500">{{ ucfirst($todayShift->status) }}</span>
                            @endif
                        @else
                            <span class="text-gray-400">Sin turno programado para hoy.</span>
                        @endif
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-lg font-bold text-gray-900 mb-1">No hay personal en Sistemas</h3>
                <p class="text-gray-500">O no se han asignado usuarios al departamento de Sistemas.</p>
            </div>
        @endforelse
    </div>
</div>
