<div class="relative" wire:poll.15s.visible="loadNotifications" x-data="{ bellOpen: false, hasPushPermission: ('Notification' in window && Notification.permission === 'granted') }" @click.outside="bellOpen = false">
    <button @click="bellOpen = !bellOpen" class="relative p-2 text-suraki-tertiary hover:text-suraki-primary transition-colors duration-200">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full border border-white animate-pulse">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Overlay oscuro solo en móvil --}}
    <div x-show="bellOpen" x-transition.opacity class="fixed inset-0 bg-black/30 z-40 sm:hidden" @click="bellOpen = false" style="display: none;"></div>

    {{-- Panel de notificaciones --}}
    <div x-show="bellOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed inset-x-3 top-16 z-50 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-2 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden"
         style="display: none;">
        
        {{-- Header --}}
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                Notificaciones
                @if($unreadCount > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $unreadCount }}</span>
                @endif
            </h3>
            <div class="flex items-center gap-2">
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-[11px] text-suraki-primary hover:text-suraki-primary-hover font-semibold hover:underline">Marcar todo leído</button>
                @endif
                <button @click="bellOpen = false" class="sm:hidden p-1 text-gray-400 hover:text-gray-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Banner Push --}}
        <div class="px-4 py-2.5 bg-amber-50 border-b border-amber-100 flex items-center justify-between" x-show="!hasPushPermission">
            <span class="text-[11px] text-amber-700 font-medium">🔔 Activa alertas en tu dispositivo</span>
            <button @click="if ('Notification' in window) { if (Notification.permission === 'denied') { alert('⚠️ Las notificaciones están bloqueadas. Ve a los ajustes del candado (junto a la URL) y cambia Notificaciones a Permitir.'); } else { Notification.requestPermission().then(p => { if (p === 'granted') { hasPushPermission = true; } }); } }" type="button" class="px-2.5 py-1 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-[11px] transition-colors shadow-sm">
                Activar
            </button>
        </div>

        {{-- Lista de notificaciones --}}
        <div class="max-h-[60vh] sm:max-h-80 overflow-y-auto divide-y divide-gray-100">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 hover:bg-gray-50 transition-colors cursor-pointer {{ is_null($notification->read_at) ? 'bg-red-50/40 border-l-[3px] border-l-red-400' : 'border-l-[3px] border-l-transparent' }}"
                     wire:click="markAsRead('{{ $notification->id }}', {{ isset($notification->data['ticket_id']) ? $notification->data['ticket_id'] : 'null' }}, {{ isset($notification->data['request_id']) ? $notification->data['request_id'] : 'null' }})">
                    
                    <div class="flex gap-3 items-start">
                        <div class="shrink-0 mt-0.5">
                            @if(is_null($notification->read_at))
                                <div class="w-2.5 h-2.5 rounded-full bg-red-500 ring-2 ring-red-100"></div>
                            @else
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-300"></div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[13px] font-medium text-gray-800 leading-snug">{{ $notification->data['message'] }}</p>
                            @if(isset($notification->data['ticket_id']))
                                <p class="text-xs text-gray-500 mt-0.5"><span class="font-semibold text-suraki-primary">TK-{{ $notification->data['ticket_id'] }}</span> {{ $notification->data['title'] ?? '' }}</p>
                            @elseif(isset($notification->data['request_id']))
                                <p class="text-xs text-gray-500 mt-0.5"><span class="font-semibold text-suraki-primary">REQ-{{ $notification->data['request_id'] }}</span></p>
                            @endif
                            <p class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center flex flex-col items-center">
                    <svg class="w-10 h-10 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    <p class="text-sm text-gray-400 font-medium">Sin notificaciones</p>
                </div>
            @endforelse
        </div>
        
        {{-- Footer --}}
        <div class="px-4 py-2.5 border-t border-gray-100 text-center bg-gray-50/80">
            <span class="text-[11px] text-gray-400">Últimas 5 notificaciones</span>
        </div>
    </div>
</div>
