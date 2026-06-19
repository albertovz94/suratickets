<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="font-mono text-sm text-suraki-tertiary bg-suraki-neutral px-2 py-0.5 rounded uppercase tracking-wider font-bold">#TK-{{ $ticket->id }}</span>
                <span class="badge-status badge-{{ $ticket->priority }} uppercase">{{ $ticket->priority }}</span>
                <span class="badge-status badge-{{ $ticket->status }} uppercase">{{ str_replace('_', ' ', $ticket->status) }}</span>
            </div>
            
            @if(auth()->user()->rol === 'admin')
            <div class="flex gap-2">
                <!-- Acciones rápidas para el admin se mantienen en la derecha -->
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('message'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg relative flex items-center gap-2">
                    <span class="block sm:inline text-sm font-medium">{{ session('message') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- COLUMNA IZQUIERDA: Chat y Detalle -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Cabecera del Problema -->
                    <div class="bg-white p-6 rounded-xl border border-suraki-neutral-dark">
                        <h3 class="text-2xl font-heading font-bold text-suraki-secondary">{{ $ticket->title }}</h3>
                        <p class="text-sm text-suraki-tertiary mt-1">
                            Reportado por <strong class="text-suraki-secondary">{{ $ticket->creator->name }}</strong> via Web Portal
                        </p>
                    </div>

                    <!-- Mensaje Inicial (Descripción Original) -->
                    <div class="bg-white p-6 rounded-xl border border-suraki-neutral-dark flex gap-4">
                        <div class="flex-shrink-0">
                            @if($ticket->creator->avatar)
                                <img src="{{ asset('storage/' . $ticket->creator->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-suraki-primary text-white flex items-center justify-center font-bold font-heading">
                                    {{ substr($ticket->creator->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <span class="font-bold text-suraki-secondary">{{ $ticket->creator->display_name ?? $ticket->creator->name }}</span>
                                    <span class="text-xs text-suraki-tertiary ml-2">Cliente / Solicitante</span>
                                </div>
                                <span class="text-xs text-suraki-tertiary">{{ $ticket->created_at->format('M d, H:i A') }}</span>
                            </div>
                            <p class="text-sm text-suraki-secondary whitespace-pre-wrap leading-relaxed">{{ $ticket->description }}</p>
                        </div>
                    </div>

                    <!-- Separador de Asignación -->
                    @if($ticket->assignedTo)
                        <div class="flex items-center justify-center gap-4">
                            <hr class="flex-grow border-suraki-neutral-dark">
                            <span class="text-xs font-mono text-suraki-tertiary flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Ticket asignado a {{ $ticket->assignedTo->name }}
                            </span>
                            <hr class="flex-grow border-suraki-neutral-dark">
                        </div>
                    @endif

                    <!-- Historial de Mensajes -->
                    @foreach($this->ticketMessages as $msg)
                    <div class="bg-{{ $msg->user->rol === 'admin' ? 'suraki-neutral' : 'white' }} p-6 rounded-xl border border-suraki-neutral-dark flex gap-4">
                        <div class="flex-shrink-0">
                            @if($msg->user->avatar)
                                <img src="{{ asset('storage/' . $msg->user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-{{ $msg->user->rol === 'admin' ? 'red-600' : 'suraki-primary' }} text-white flex items-center justify-center font-bold font-heading">
                                    {{ substr($msg->user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <span class="text-xs text-{{ $msg->user->rol === 'admin' ? 'red-600' : 'suraki-tertiary' }} font-bold mr-2">{{ $msg->user->rol === 'admin' ? 'Soporte Técnico' : 'Cliente' }}</span>
                                    <span class="font-bold text-suraki-secondary">{{ $msg->user->display_name ?? $msg->user->name }}</span>
                                </div>
                                <span class="text-xs text-suraki-tertiary">{{ $msg->created_at->format('M d, H:i A') }}</span>
                            </div>
                            <p class="text-sm text-suraki-secondary whitespace-pre-wrap leading-relaxed">{{ $msg->message }}</p>
                        </div>
                    </div>
                    @endforeach

                    <!-- Cuadro de Respuesta (Si está en proceso o resuelto) -->
                    @if(in_array($ticket->status, ['abierto', 'asignado', 'en_proceso', 'resuelto']))
                        <div class="bg-white p-6 rounded-xl border border-suraki-neutral-dark shadow-sm mt-6">
                            <form wire:submit.prevent="sendMessage">
                                <textarea wire:model="newMessage" rows="3" class="w-full border-0 focus:ring-0 resize-none text-sm p-0 mb-3" placeholder="Escribe tu respuesta aquí..."></textarea>
                                <div class="flex justify-between items-center border-t border-suraki-neutral-dark pt-3">
                                    <span class="text-xs text-suraki-tertiary flex items-center gap-1"><input type="checkbox" class="rounded border-suraki-neutral-dark text-suraki-primary focus:ring-suraki-primary w-3 h-3"> Nota Interna (Pronto)</span>
                                    <x-primary-button wire:loading.attr="disabled">
                                        Enviar Mensaje
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="text-center p-4 text-sm text-suraki-tertiary bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            El ticket está <strong>{{ $ticket->status }}</strong>. No se pueden enviar más mensajes.
                        </div>
                    @endif
                    
                    <!-- Plan de Acción Destacado -->
                    @if($ticket->resolution_summary && in_array($ticket->status, ['resuelto', 'cerrado']))
                        <div class="bg-green-50 p-6 rounded-xl border border-green-200 mt-6 shadow-sm">
                            <h4 class="text-sm font-heading font-bold text-green-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Plan de Acción / Resolución Final
                            </h4>
                            <p class="text-sm text-green-700 whitespace-pre-wrap">{{ $ticket->resolution_summary }}</p>
                        </div>
                    @endif
                </div>

                <!-- COLUMNA DERECHA: Información y Contacto -->
                <div class="space-y-6">
                    
                    <!-- Información del Ticket -->
                    <div class="bg-white p-6 rounded-xl border border-suraki-neutral-dark">
                        <h4 class="text-sm font-heading font-bold text-suraki-secondary uppercase tracking-wider mb-4">Información del Ticket</h4>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-xs text-suraki-tertiary mb-1">Departamento</p>
                                <span class="font-medium text-suraki-secondary">{{ optional($ticket->departamento)->nombre }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-suraki-tertiary">Creado</span>
                                <span class="font-medium text-suraki-secondary">{{ $ticket->created_at->format('M d, H:i A') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-suraki-tertiary text-xs">
                                    {{ in_array($ticket->status, ['resuelto', 'cerrado']) ? 'Tiempo de Resolución' : 'Tiempo Transcurrido' }}
                                </span>
                                @if(in_array($ticket->status, ['resuelto', 'cerrado']))
                                    <span class="font-medium text-green-600 flex items-center gap-1 text-sm">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $ticket->created_at->diffForHumans($ticket->updated_at, true) }}
                                    </span>
                                @else
                                    <span class="font-medium text-red-600 flex items-center gap-1 text-sm">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-suraki-neutral-dark">
                            <h4 class="text-xs text-suraki-tertiary mb-2">Etiquetas</h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="text-xs bg-suraki-neutral px-2 py-1 rounded text-suraki-secondary">{{ strtolower($ticket->sucursal->nombre ?? 'N/A') }}</span>
                                @if($ticket->equipo_afectado)
                                    <span class="text-xs bg-suraki-neutral px-2 py-1 rounded text-suraki-secondary">{{ strtolower($ticket->equipo_afectado) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Detalles de Contacto -->
                    @php
                        $contact = auth()->user()->rol === 'admin' ? $ticket->creator : ($ticket->assignedTo ?? null);
                    @endphp
                    
                    @if($contact)
                    <div class="bg-white p-6 rounded-xl border border-suraki-neutral-dark">
                        <h4 class="text-sm font-heading font-bold text-suraki-secondary uppercase tracking-wider mb-4">
                            {{ auth()->user()->rol === 'admin' ? 'Detalles de Contacto' : 'Técnico Asignado' }}
                        </h4>
                        <div class="flex items-center gap-3 mb-4">
                            @if($contact->avatar)
                                <img src="{{ asset('storage/' . $contact->avatar) }}" alt="Avatar" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-suraki-primary text-white flex items-center justify-center font-bold font-heading text-lg">
                                    {{ substr($contact->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-suraki-secondary">{{ $contact->name }} {{ $contact->last_name }}</p>
                                <p class="text-xs text-suraki-tertiary">{{ optional($contact->departamento)->nombre ?? 'Usuario del Sistema' }}</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm text-suraki-secondary">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-suraki-tertiary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                {{ $contact->email }}
                            </div>
                            @if($contact->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-suraki-tertiary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                {{ $contact->phone }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Admin: Gestión del Ticket -->
                    @if(auth()->user()->rol === 'admin')
                    <div class="bg-suraki-neutral p-6 rounded-xl border border-suraki-neutral-dark">
                        <h4 class="text-sm font-heading font-bold text-suraki-secondary uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Gestión de Ticket
                        </h4>
                        <form wire:submit.prevent="updateTicket" class="space-y-4">
                            <div>
                                <x-input-label for="status" value="Estado" />
                                <select wire:model="status" id="status" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary rounded-lg shadow-sm text-sm">
                                    <option value="abierto">Abierto</option>
                                    <option value="asignado">Asignado</option>
                                    <option value="en_proceso">En Proceso</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="resuelto">Resuelto</option>
                                    <option value="cerrado">Cerrado</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="assigned_to" value="Asignar Técnico" />
                                <select wire:model="assigned_to" id="assigned_to" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary rounded-lg shadow-sm text-sm">
                                    <option value="">— Sin Asignar —</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="resolution_summary" value="Plan de Acción / Diagnóstico Final" />
                                <textarea wire:model="resolution_summary" id="resolution_summary" rows="3" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary rounded-lg shadow-sm text-sm" placeholder="Describe la solución o causa raíz..."></textarea>
                                <x-input-error :messages="$errors->get('resolution_summary')" class="mt-2" />
                            </div>
                            <x-primary-button class="w-full justify-center text-sm py-2">Actualizar Estado</x-primary-button>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
