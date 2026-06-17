<div>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-heading font-bold text-xl text-suraki-secondary leading-tight">
                {{ __('Detalle de Ticket') }}
            </h2>
            <span class="font-mono text-sm text-suraki-tertiary bg-suraki-neutral px-2 py-0.5 rounded">#{{ $ticket->id }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card-suraki">
                <div class="p-6">

                    @if (session()->has('message'))
                        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg relative animate-fade-in flex items-center gap-2" role="alert">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="block sm:inline text-sm font-medium">{{ session('message') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column: Ticket Information -->
                        <div class="md:col-span-2 space-y-6">
                            <div class="bg-white p-6 rounded-xl border border-suraki-neutral-dark">
                                <div>
                                    <h3 class="text-2xl font-heading font-bold text-suraki-primary">{{ $ticket->title }}</h3>
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <span class="badge-status badge-{{ $ticket->estatus }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->estatus)) }}
                                        </span>
                                        <span class="badge-status badge-{{ $ticket->priority }}">
                                            Prioridad: {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="my-5 border-suraki-neutral-dark">

                                <div>
                                    <h4 class="text-xs font-semibold text-suraki-tertiary uppercase tracking-wider">Descripción del Problema</h4>
                                    <p class="mt-2 text-suraki-secondary whitespace-pre-wrap leading-relaxed">{{ $ticket->description }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4 bg-suraki-neutral p-4 rounded-lg mt-5">
                                    <div>
                                        <p class="text-xs font-semibold text-suraki-tertiary uppercase tracking-wider">Sucursal</p>
                                        <p class="text-suraki-secondary font-medium mt-1">{{ $ticket->sucursal->nombre }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-suraki-tertiary uppercase tracking-wider">Área / Depto</p>
                                        <p class="text-suraki-secondary font-medium mt-1">{{ $ticket->area_departamento }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-suraki-tertiary uppercase tracking-wider">Equipo Afectado</p>
                                        <p class="text-suraki-secondary font-medium mt-1">{{ $ticket->equipo_afectado }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-suraki-tertiary uppercase tracking-wider">Creado Por</p>
                                        <p class="text-suraki-secondary font-medium mt-1">{{ $ticket->creator->name }} <span class="font-mono text-suraki-tertiary text-xs">({{ $ticket->creator->username }})</span></p>
                                        <p class="text-xs text-suraki-tertiary font-mono mt-0.5">{{ $ticket->created_at->format('d/m/Y H:i A') }}</p>
                                    </div>
                                </div>

                                @if(auth()->user()->rol !== 'admin' && $ticket->resolution_summary)
                                <div class="mt-5 bg-emerald-50 p-5 border border-emerald-200 rounded-lg">
                                    <h4 class="text-xs font-semibold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Respuesta del Técnico
                                    </h4>
                                    <p class="mt-2 text-emerald-900 whitespace-pre-wrap leading-relaxed">{{ $ticket->resolution_summary }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right Column: Admin Actions / User Status -->
                        <div class="space-y-4">
                            @if(auth()->user()->rol === 'admin')
                                <div class="bg-white p-6 rounded-xl border border-suraki-neutral-dark">
                                    <h3 class="text-base font-heading font-semibold text-suraki-secondary mb-4 pb-3 border-b border-suraki-neutral-dark flex items-center gap-2">
                                        <svg class="w-5 h-5 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.648-3.01M11.42 15.17l5.648-3.01M11.42 15.17V20.28M6.772 12.16l-1.648 4.37M17.228 12.16l1.648 4.37M11.42 4.02l5.648 3.01M11.42 4.02L5.772 7.03M11.42 4.02V8.74" />
                                        </svg>
                                        Gestión de Ticket
                                    </h3>

                                    <form wire:submit.prevent="updateTicket" class="space-y-4">
                                        <div>
                                            <x-input-label for="status" value="Estado" />
                                            <select wire:model="status" id="status" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm text-sm transition-colors duration-150">
                                                <option value="abierto">Abierto</option>
                                                <option value="asignado">Asignado</option>
                                                <option value="en_proceso">En Proceso</option>
                                                <option value="pendiente">Pendiente</option>
                                                <option value="resuelto">Resuelto</option>
                                                <option value="cerrado">Cerrado</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="assigned_to" value="Asignar a" />
                                            <select wire:model="assigned_to" id="assigned_to" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm text-sm transition-colors duration-150">
                                                <option value="">— Sin Asignar —</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="resolution_summary" value="Resumen / Resolución" />
                                            <textarea wire:model="resolution_summary" id="resolution_summary" class="mt-1 block w-full border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm text-sm transition-colors duration-150" rows="3" placeholder="Escribe aquí la solución para el usuario..."></textarea>
                                            <x-input-error :messages="$errors->get('resolution_summary')" class="mt-2" />
                                        </div>

                                        <div class="pt-3">
                                            <x-primary-button class="w-full justify-center">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                Guardar Cambios
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <!-- User Status Panel -->
                                <div class="bg-suraki-primary/5 p-6 rounded-xl border border-suraki-primary/15">
                                    <h3 class="text-base font-heading font-semibold text-suraki-secondary mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                        </svg>
                                        Estado del Soporte
                                    </h3>
                                    <p class="text-sm text-suraki-tertiary">Tu ticket está actualmente <span class="badge-status badge-{{ $ticket->estatus }} ml-1">{{ str_replace('_', ' ', $ticket->estatus) }}</span></p>
                                    @if($ticket->assignedTo)
                                        <p class="text-sm text-suraki-tertiary mt-3">Técnico asignado: <strong class="text-suraki-secondary">{{ $ticket->assignedTo->name }}</strong></p>
                                    @else
                                        <p class="text-sm text-suraki-tertiary mt-3">Pronto un administrador será asignado a tu caso.</p>
                                    @endif
                                </div>
                            @endif

                            <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm text-suraki-primary hover:text-suraki-primary-hover transition-colors duration-150 font-medium mt-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                </svg>
                                Volver al Listado
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
