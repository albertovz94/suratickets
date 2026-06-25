<div class="space-y-6" wire:poll.180s>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Solicitudes de Equipamiento IT</h2>
            <p class="text-sm text-gray-500">Gestiona las solicitudes de hardware y equipo de los usuarios.</p>
        </div>
        <div>
            <a href="{{ route('requests.create') }}" wire:navigate class="inline-flex items-center gap-2 bg-suraki-primary hover:bg-suraki-secondary text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Solicitud
            </a>
        </div>
    </div>



    <!-- Tabs Navigation -->
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl max-w-fit">
        <button wire:click="setTab('pendiente')" 
            class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'pendiente' ? 'bg-white text-suraki-primary shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
            Pendientes
        </button>
        <button wire:click="setTab('aprobado')" 
            class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'aprobado' ? 'bg-white text-suraki-primary shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
            Aprobados
        </button>
        <button wire:click="setTab('rechazado')" 
            class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'rechazado' ? 'bg-white text-suraki-primary shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
            Rechazados
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-900 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-bold">ID</th>
                        @if(auth()->user()->hasAdminAccess())
                            <th class="px-6 py-4 font-bold">Usuario</th>
                        @endif
                        <th class="px-6 py-4 font-bold">Departamento</th>
                        <th class="px-6 py-4 font-bold">Equipo Solicitado</th>
                        <th class="px-6 py-4 font-bold">Urgencia</th>
                        <th class="px-6 py-4 font-bold">Asignado a</th>
                        <th class="px-6 py-4 font-bold">Descripción</th>
                        <th class="px-6 py-4 font-bold">Estado</th>
                        <th class="px-6 py-4 font-bold text-right">Fecha</th>
                        @if(auth()->user()->hasAdminAccess())
                            <th class="px-6 py-4 font-bold text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-600">
                    @forelse($solicitudes as $solicitud)
                        <tr wire:key="solicitud-{{ $solicitud->id }}" class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">#{{ $solicitud->id }}</td>
                            @if(auth()->user()->hasAdminAccess())
                                <td class="px-6 py-4 font-medium">{{ $solicitud->user->name ?? 'N/A' }}</td>
                            @endif
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($solicitud->user && $solicitud->user->department)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $solicitud->user->department->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Sin Departamento</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-suraki-primary">{{ $solicitud->device_type }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $urgencyColors = [
                                        'baja' => 'bg-gray-100 text-gray-800',
                                        'media' => 'bg-blue-100 text-blue-800',
                                        'alta' => 'bg-orange-100 text-orange-800',
                                        'critica' => 'bg-red-100 text-red-800',
                                    ];
                                    $urgColor = $urgencyColors[$solicitud->urgency ?? 'media'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-md uppercase {{ $urgColor }}">
                                    {{ $solicitud->urgency ?? 'Media' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ $solicitud->assignedTo->name ?? 'Sin asignar' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="line-clamp-2" title="{{ $solicitud->description }}">
                                    {{ $solicitud->description }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'aprobado'  => 'bg-blue-100 text-blue-800',
                                        'rechazado' => 'bg-red-100 text-red-800',
                                        'entregado' => 'bg-green-100 text-green-800',
                                    ];
                                    $colorClass = $statusColors[$solicitud->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase {{ $colorClass }}">
                                    {{ $solicitud->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-400 text-xs">
                                {{ $solicitud->created_at->format('d/m/Y H:i') }}
                            </td>
                            @if(auth()->user()->hasAdminAccess())
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($solicitud->status === 'pendiente')
                                            <button wire:click="updateStatus({{ $solicitud->id }}, 'aprobado')" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition" title="Aprobar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </button>
                                            <button wire:click="updateStatus({{ $solicitud->id }}, 'rechazado')" class="p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition" title="Rechazar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        @elseif($solicitud->status === 'aprobado')
                                            <button wire:click="updateStatus({{ $solicitud->id }}, 'entregado')" class="p-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100 transition flex gap-1 items-center px-3" title="Marcar como entregado">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="text-xs font-bold">Entregar</span>
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400 font-semibold">—</span>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasAdminAccess() ? '10' : '8' }}" class="px-6 py-12 text-center text-gray-500">
                                No hay solicitudes registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $solicitudes->links() }}
        </div>
    </div>
</div>
