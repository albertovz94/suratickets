<div class="relative" wire:poll.15s.visible="loadNotifications" x-data="{ open: false }" @click.outside="open = false">
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

        <!-- Botón explícito para solicitar Notificaciones Push en Celulares y PC -->
        <div class="p-3 bg-amber-50 border-b border-amber-200 flex items-center justify-between text-xs text-amber-800" x-data="{ pushGranted: ('Notification' in window && Notification.permission === 'granted') }" x-show="!pushGranted">
            <span class="text-[11px] font-medium">¿Alertas en tu teléfono o PC?</span>
            <button @click="if ('Notification' in window) { Notification.requestPermission().then(p => { if (p === 'granted') { pushGranted = true; alert('¡Notificaciones Push activadas en tu dispositivo!'); } else { alert('Debes permitir las notificaciones en los ajustes de tu navegador.'); } }); } else { alert('Este navegador no soporta notificaciones push.'); }" type="button" class="px-2.5 py-1 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg text-[11px] transition-colors shadow-sm flex items-center gap-1">
                🔔 Activar Push
            </button>
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-suraki-neutral-dark last:border-b-0 hover:bg-suraki-neutral transition-colors cursor-pointer {{ is_null($notification->read_at) ? 'bg-red-50/50' : '' }}"
                     wire:click="markAsRead('{{ $notification->id }}', {{ isset($notification->data['ticket_id']) ? $notification->data['ticket_id'] : 'null' }}, {{ isset($notification->data['request_id']) ? $notification->data['request_id'] : 'null' }})">
                    
                    <div class="flex gap-3">
                        <div class="mt-0.5">
                            @if(is_null($notification->read_at))
                                <button wire:click.stop="markAsRead('{{ $notification->id }}')" class="w-5 h-5 mt-1 rounded-full bg-red-50 hover:bg-green-100 border border-red-200 hover:border-green-300 flex items-center justify-center text-red-500 hover:text-green-600 transition-colors" title="Marcar como leído">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            @else
                                <div class="w-5 h-5 mt-1 rounded-full flex items-center justify-center text-gray-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-medium text-suraki-secondary mb-1">{{ $notification->data['message'] }}</p>
                            @if(isset($notification->data['ticket_id']))
                                <p class="text-xs text-suraki-tertiary"><strong>TK-{{ $notification->data['ticket_id'] }}:</strong> {{ $notification->data['title'] ?? '' }}</p>
                            @elseif(isset($notification->data['request_id']))
                                <p class="text-xs text-suraki-tertiary"><strong>REQ-{{ $notification->data['request_id'] }}</strong></p>
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
