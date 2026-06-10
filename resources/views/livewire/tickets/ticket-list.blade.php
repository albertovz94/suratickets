<div wire:poll.10s>
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button wire:click="setTab('activos')" class="{{ $activeTab === 'activos' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Tickets Activos
            </button>
            <button wire:click="setTab('historial')" class="{{ $activeTab === 'historial' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Cerrados / Resueltos
            </button>
        </nav>
    </div>

    <div class="mb-4 flex flex-col md:flex-row gap-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar tickets por título o descripción..." class="form-input rounded-md shadow-sm border-gray-300 flex-1">
        
        @if(auth()->user()->rol === 'admin')
            <select wire:model.live="status" class="form-select rounded-md shadow-sm border-gray-300">
                <option value="">Todos los estados</option>
                <option value="abierto">Abierto</option>
                <option value="asignado">Asignado</option>
                <option value="en_proceso">En Proceso</option>
                <option value="pendiente">Pendiente</option>
                <option value="resuelto">Resuelto</option>
                <option value="cerrado">Cerrado</option>
            </select>
            <select wire:model.live="priority" class="form-select rounded-md shadow-sm border-gray-300">
                <option value="">Todas las prioridades</option>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="critica">Crítica</option>
            </select>
        @endif
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($tickets as $ticket)
            <li>
                <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="block hover:bg-gray-50 transition cursor-pointer">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $ticket->title }}</p>
                            <div class="ml-2 flex-shrink-0 flex gap-2">
                            @if($ticket->priority === 'critica')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Crítico
                                </span>
                            @endif
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex flex-col gap-1">
                            <p class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                </svg>
                                {{ $ticket->sucursal->nombre }} - {{ $ticket->area_departamento }}
                            </p>
                            @if(in_array($ticket->status, ['resuelto', 'cerrado']) && $ticket->assignedTo)
                                <p class="flex items-center text-sm text-emerald-600 font-medium">
                                    Resuelto por: {{ $ticket->assignedTo->username }}
                                </p>
                            @endif
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                            <p>Actualizado {{ $ticket->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            </li>
            @empty
            <li class="px-4 py-4 sm:px-6 text-gray-500 text-center">No se encontraron tickets con los filtros actuales.</li>
            @endforelse
        </ul>
    </div>
    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</div>
