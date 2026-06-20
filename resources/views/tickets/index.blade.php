<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-heading font-bold text-2xl text-suraki-secondary leading-tight">
                    {{ __('Tickets') }}
                </h2>
                <p class="text-sm text-suraki-tertiary mt-1">Gestión y seguimiento de tus solicitudes</p>
            </div>
            <a href="{{ route('tickets.create') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-suraki-primary text-white rounded-lg text-sm font-semibold hover:bg-suraki-primary-hover transition-all duration-200 shadow-sm shadow-suraki-primary/20">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nuevo Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-4 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Tickets List Card -->
            <div class="card-suraki">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h3 class="text-lg font-heading font-semibold text-suraki-secondary">
                            {{ auth()->user()->rol === 'admin' ? 'Gestión de Todos los Tickets' : 'Mis Tickets' }}
                        </h3>
                        
                        <!-- Botón siempre visible en móviles y desktop -->
                        <a href="{{ route('tickets.create') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-suraki-primary text-white rounded-lg text-sm font-semibold hover:bg-suraki-primary-hover transition-all duration-200 shadow-sm w-full sm:w-auto justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Crear Nuevo Ticket
                        </a>
                    </div>
                    
                    <livewire:tickets.ticket-list />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
