<div wire:poll.5s="updateCount" class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-suraki-primary focus:ring-offset-2 focus:ring-offset-suraki-secondary rounded-full transition-colors duration-150">
        <span class="sr-only">Ver notificaciones</span>
        <svg class="h-6 w-6 {{ $unreadCount > 0 ? 'animate-pulse-bell' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-suraki-primary ring-2 ring-suraki-secondary text-xs text-white text-center flex items-center justify-center font-bold font-mono">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-xl bg-white py-1 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none animate-fade-in" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <div class="px-4 py-3 border-b border-suraki-neutral-dark flex justify-between items-center">
            <h3 class="text-sm font-heading font-semibold text-suraki-secondary">Notificaciones</h3>
            @if($unreadCount > 0)
                <button wire:click="markAsRead" class="text-xs text-suraki-primary hover:text-suraki-primary-hover font-medium transition-colors duration-150">Marcar leídas</button>
            @endif
        </div>
        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 border-b border-suraki-neutral hover:bg-suraki-neutral transition-colors duration-150 {{ empty($notification->read_at) ? 'bg-suraki-primary-light/50 border-l-2 border-l-suraki-primary' : '' }}">
                    <p class="text-sm text-suraki-secondary">
                        @if(isset($notification->data['message']))
                            {{ $notification->data['message'] }}
                        @else
                            Nueva notificación
                        @endif
                    </p>
                    <p class="text-xs text-suraki-tertiary mt-1 font-mono">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="px-4 py-8 text-sm text-suraki-tertiary text-center">
                    <svg class="w-8 h-8 mx-auto mb-2 text-suraki-neutral-dark" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    No tienes notificaciones nuevas.
                </div>
            @endforelse
        </div>
    </div>
</div>
