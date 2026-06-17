<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-xl text-suraki-secondary leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card-suraki">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Mis Tickets</h3>
                        <a href="{{ route('tickets.create') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-suraki-primary text-white rounded-lg text-sm font-semibold hover:bg-suraki-primary-hover transition-colors duration-150 shadow-sm shadow-suraki-primary/20">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Nuevo Ticket
                        </a>
                    </div>
                    <livewire:tickets.ticket-list />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
