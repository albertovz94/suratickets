<div class="relative" wire:poll.180s="loadNotifications" x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open" class="relative p-2 text-suraki-tertiary hover:text-suraki-primary transition-colors duration-200">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full border border-white">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-suraki-neutral-dark z-50 overflow-hidden"
         style="display: none;">
        
        <div class="p-4 border-b border-suraki-neutral-dark flex justify-between items-center bg-suraki-neutral/30">
            <h3 class="text-sm font-bold text-suraki-secondary">Notificaciones</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-suraki-primary hover:text-suraki-primary-hover font-medium">Marcar todo como leído</button>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-suraki-neutral-dark last:border-b-0 hover:bg-suraki-neutral transition-colors cursor-pointer {{ is_null($notification->read_at) ? 'bg-red-50/50' : '' }}"
                     wire:click="markAsRead('{{ $notification->id }}', {{ isset($notification->data['ticket_id']) ? $notification->data['ticket_id'] : 'null' }})">
                    
                    <div class="flex gap-3">
                        <div class="mt-0.5">
                            @if(is_null($notification->read_at))
                                <div class="w-2 h-2 mt-1.5 rounded-full bg-red-500"></div>
                            @else
                                <div class="w-2 h-2 mt-1.5 rounded-full bg-gray-300"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-medium text-suraki-secondary mb-1">{{ $notification->data['message'] }}</p>
                            @if(isset($notification->data['ticket_id']))
                                <p class="text-xs text-suraki-tertiary"><strong>TK-{{ $notification->data['ticket_id'] }}:</strong> {{ $notification->data['title'] ?? '' }}</p>
                            @endif
                            <p class="text-[10px] text-suraki-tertiary mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-suraki-tertiary flex flex-col items-center">
                    <svg class="w-8 h-8 mb-2 text-suraki-neutral-dark" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    <p class="text-sm">No tienes notificaciones nuevas</p>
                </div>
            @endforelse
        </div>
        
        <div class="p-3 border-t border-suraki-neutral-dark text-center bg-gray-50">
            <span class="text-xs text-suraki-tertiary font-medium">Mostrando las últimas 5 notificaciones</span>
        </div>
    </div>
</div>
