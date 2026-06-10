<div wire:poll.5s="updateCount" class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full">
        <span class="sr-only">Ver notificaciones</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-red-500 ring-2 ring-white text-xs text-white text-center flex items-center justify-center font-bold">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-900">Notificaciones</h3>
            @if($unreadCount > 0)
                <button wire:click="markAsRead" class="text-xs text-indigo-600 hover:text-indigo-900">Marcar leídas</button>
            @endif
        </div>
        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 {{ empty($notification->read_at) ? 'bg-blue-50' : '' }}">
                    <p class="text-sm text-gray-800">
                        @if(isset($notification->data['message']))
                            {{ $notification->data['message'] }}
                        @else
                            Nueva notificación
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="px-4 py-3 text-sm text-gray-500 text-center">
                    No tienes notificaciones nuevas.
                </div>
            @endforelse
        </div>
    </div>
</div>
