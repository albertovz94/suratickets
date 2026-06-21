<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Bitácora del Sistema</h2>
            <p class="text-sm text-gray-500">Registro histórico de acciones y navegación para auditoría.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-suraki-neutral-dark p-2 flex gap-2">
        <button wire:click="setTab('acciones')" class="px-6 py-2 rounded-lg font-semibold text-sm transition-colors {{ $tab === 'acciones' ? 'bg-suraki-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Acciones del Usuario
        </button>
        <button wire:click="setTab('rutas')" class="px-6 py-2 rounded-lg font-semibold text-sm transition-colors {{ $tab === 'rutas' ? 'bg-suraki-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Registro de Rutas
        </button>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-suraki-neutral-dark overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-900 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Fecha y Hora</th>
                        <th class="px-6 py-4 font-semibold">Usuario</th>
                        @if($tab === 'acciones')
                            <th class="px-6 py-4 font-semibold">Acción</th>
                            <th class="px-6 py-4 font-semibold">Detalles</th>
                        @else
                            <th class="px-6 py-4 font-semibold">Ruta Visitada</th>
                            <th class="px-6 py-4 font-semibold">Método</th>
                        @endif
                        <th class="px-6 py-4 font-semibold text-right">Dirección IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900">{{ $log->created_at->format('d/m/Y') }}</span>
                                <span class="text-gray-500 ml-1">{{ $log->created_at->format('H:i:s') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->user)
                                    <div class="flex items-center gap-3">
                                        @if($log->user->avatar_path)
                                            <img src="{{ $log->user->avatar_path }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-suraki-primary text-white flex items-center justify-center font-bold text-xs">
                                                {{ substr($log->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $log->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $log->user->username }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Sistema / Anónimo</span>
                                @endif
                            </td>

                            @if($tab === 'acciones')
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $log->action }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $log->description }}
                                </td>
                            @else
                                <td class="px-6 py-4">
                                    <code class="text-xs bg-gray-100 text-pink-600 px-2 py-1 rounded">{{ $log->url }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $log->method === 'GET' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $log->method }}
                                    </span>
                                </td>
                            @endif

                            <td class="px-6 py-4 text-right font-mono text-xs text-gray-500">
                                {{ $log->ip_address ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No hay registros disponibles en esta bitácora.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
