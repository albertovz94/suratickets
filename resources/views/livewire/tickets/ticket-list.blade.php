<div wire:poll.180s>
    <!-- Pestañas -->
    <div class="flex gap-2 mb-6 border-b border-suraki-neutral-dark pb-0">
        <button wire:click="setTab('asignados')" class="px-5 py-2.5 text-sm font-bold rounded-t-xl transition-colors duration-200 {{ $activeTab === 'asignados' ? 'bg-orange-50 text-orange-700 border-b-2 border-orange-500 shadow-inner' : 'text-suraki-tertiary hover:text-suraki-secondary hover:bg-suraki-neutral' }}">
            Pendientes / Asignados
        </button>
        <button wire:click="setTab('resueltos')" class="px-5 py-2.5 text-sm font-bold rounded-t-xl transition-colors duration-200 {{ $activeTab === 'resueltos' ? 'bg-green-50 text-green-700 border-b-2 border-green-500 shadow-inner' : 'text-suraki-tertiary hover:text-suraki-secondary hover:bg-suraki-neutral' }}">
            Resueltos
        </button>
    </div>

    <div class="mb-6 flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-suraki-tertiary/50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar tickets por título o descripción..." class="w-full pl-10 pr-4 py-2.5 border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm text-sm transition-colors duration-150">
        </div>

        @if(auth()->user()->hasAdminAccess())
            <select wire:model.live="status" class="py-2.5 border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm text-sm text-suraki-tertiary transition-colors duration-150">
                <option value="">Todos los estados</option>
                <option value="abierto">Abierto</option>
                <option value="asignado">Asignado</option>
                <option value="en_proceso">En Proceso</option>
                <option value="pendiente">Pendiente</option>
                <option value="resuelto">Resuelto</option>
                <option value="cerrado">Cerrado</option>
            </select>
            <select wire:model.live="priority" class="py-2.5 border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm text-sm text-suraki-tertiary transition-colors duration-150">
                <option value="">Todas las prioridades</option>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="critica">Crítica</option>
            </select>
        @endif
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-suraki-neutral-dark overflow-hidden">
        <ul role="list" class="divide-y divide-suraki-neutral-dark">
            @forelse($tickets as $ticket)
            <li class="animate-fade-in">
                <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="block hover:bg-suraki-neutral transition-colors duration-150 cursor-pointer">
                    <div class="px-5 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-suraki-primary truncate">{{ $ticket->title }}</p>
                            <div class="ml-2 flex-shrink-0 flex gap-2">
                                <span class="badge-status badge-{{ $ticket->priority }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                                @if($ticket->categoria)
                                <span class="badge-status" style="background-color: #f3f4f6; color: #4b5563; border-color: #d1d5db;">
                                    {{ ucfirst($ticket->categoria) }}
                                </span>
                                @endif
                                <span class="badge-status badge-{{ $ticket->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-suraki-tertiary">
                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-suraki-tertiary/50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5M3.75 3v18m16.5-18v18M5.25 3h13.5M5.25 21h13.5m-13.5-18v18M18.75 3v18m-11.25-4.5h7.5m-7.5-3h7.5m-7.5-3h7.5m-7.5-3h7.5" />
                                    </svg>
                                    {{ optional($ticket->branch)->name }} — {{ optional($ticket->department)->name }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-suraki-tertiary/70 sm:mt-0">
                                <p class="font-mono text-xs">Actualizado {{ $ticket->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @empty
            <li class="px-5 py-12 text-center">
                <svg class="w-12 h-12 mx-auto mb-3 text-suraki-neutral-dark" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
                <p class="text-suraki-tertiary font-medium">No se encontraron tickets</p>
                <p class="text-suraki-tertiary/60 text-sm mt-1">Intenta con otros filtros o crea un nuevo ticket.</p>
            </li>
            @endforelse
        </ul>
    </div>
    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</div>
