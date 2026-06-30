<div class="space-y-6" wire:poll.180s>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Solicitudes de Equipamiento IT</h2>
            <p class="text-sm text-gray-500">Gestiona las solicitudes de hardware y equipo de los usuarios.</p>
        </div>
        <div>
            <a href="{{ route('requests.create') }}" wire:navigate class="blob-btn shadow-sm" style="width: 220px; padding: 10px 20px;">
                <span style="position:relative; z-index: 10;" class="flex items-center gap-2 text-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Solicitud
                </span>
                <span class="blob-btn__inner"><span class="blob-btn__blobs"><span class="blob-btn__blob"></span><span class="blob-btn__blob"></span><span class="blob-btn__blob"></span><span class="blob-btn__blob"></span></span></span>
            </a>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl max-w-fit">
        <button wire:click="setTab('pendiente')" 
            class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'pendiente' ? 'bg-white text-suraki-primary shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
            Pendientes
        </button>
        <button wire:click="setTab('en_proceso')" 
            class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'en_proceso' ? 'bg-white text-suraki-primary shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
            En Proceso
        </button>
        <button wire:click="setTab('entregado')" 
            class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'entregado' ? 'bg-white text-suraki-primary shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
            Entregados
        </button>
        <button wire:click="setTab('rechazado')" 
            class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'rechazado' ? 'bg-white text-suraki-primary shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
            Rechazados
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-900 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-bold">ID / Fecha</th>
                        @if(auth()->user()->hasAdminAccess())
                            <th class="px-6 py-4 font-bold">Usuario & Depto</th>
                        @endif
                        <th class="px-6 py-4 font-bold">Equipo / Urgencia</th>
                        <th class="px-6 py-4 font-bold">Asignado a</th>
                        <th class="px-6 py-4 font-bold">Estado</th>
                        <th class="px-6 py-4 font-bold text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody wire:loading.class="hidden" class="divide-y divide-gray-100 text-gray-600">
                    @forelse($solicitudes as $solicitud)
                        <tr wire:key="solicitud-{{ $solicitud->id }}" class="hover:bg-gray-50 transition-colors">
                            <!-- ID and Date -->
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">#{{ $solicitud->id }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $solicitud->created_at->format('d/m/Y') }}</div>
                            </td>
                            
                            <!-- User & Depto -->
                            @if(auth()->user()->hasAdminAccess())
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs">
                                            {{ substr($solicitud->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $solicitud->user->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">{{ $solicitud->user->department->name ?? 'Sin Depto' }}</div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            
                            <!-- Device & Urgency -->
                            <td class="px-6 py-4">
                                <div class="font-semibold text-suraki-primary">{{ $solicitud->device_type }}</div>
                                <div class="mt-1">
                                    @php
                                        $urgColor = match($solicitud->urgency) {
                                            'baja' => 'bg-gray-100 text-gray-800',
                                            'media' => 'bg-blue-100 text-blue-800',
                                            'alta' => 'bg-orange-100 text-orange-800',
                                            'critica' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded-md uppercase {{ $urgColor }}">
                                        {{ $solicitud->urgency ?? 'Media' }}
                                    </span>
                                </div>
                            </td>
                            
                            <!-- Assigned -->
                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ $solicitud->assignedTo->name ?? 'Sin asignar' }}
                            </td>
                            
                            <!-- Status -->
                            <td class="px-6 py-4">
                                @php
                                    $colorClass = match($solicitud->status) {
                                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'en_proceso'  => 'bg-blue-100 text-blue-800',
                                        'rechazado' => 'bg-red-100 text-red-800',
                                        'entregado' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase {{ $colorClass }}">
                                    {{ str_replace('_', ' ', $solicitud->status) }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openDetailModal({{ $solicitud->id }})" class="p-1.5 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition" title="Ver Detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    @if(auth()->user()->hasAdminAccess())
                                        @if($solicitud->status === 'pendiente')
                                            <button wire:click="openActionModal({{ $solicitud->id }}, 'aprobar')" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition" title="Aprobar / Iniciar Proceso">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                            <button wire:click="openActionModal({{ $solicitud->id }}, 'rechazar')" class="p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition" title="Rechazar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        @elseif($solicitud->status === 'en_proceso')
                                            <button wire:click="openActionModal({{ $solicitud->id }}, 'entregar')" class="p-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100 transition flex gap-1 items-center px-3" title="Marcar como entregado">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="text-xs font-bold">Entregar</span>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasAdminAccess() ? 6 : 5 }}" class="px-6 py-16 text-center">
                                <div class="max-w-md mx-auto flex flex-col items-center">
                                    <div class="w-16 h-16 bg-suraki-neutral rounded-2xl flex items-center justify-center text-suraki-tertiary/60 mb-4 border border-suraki-neutral-dark shadow-inner">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.244 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.244 2.25H5.25A2.25 2.25 0 013 12V5.25"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-suraki-secondary">Sin solicitudes</h3>
                                    <p class="text-sm text-suraki-tertiary mt-1">No hay solicitudes registradas bajo el estado actual o los términos especificados.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <!-- Skeleton Loader -->
                <tbody wire:loading.class.remove="hidden" class="divide-y divide-gray-100 text-gray-600 hidden">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="h-4 bg-gray-200 rounded w-12 mb-1 animate-pulse"></div>
                                <div class="h-3 bg-gray-200 rounded w-16 animate-pulse"></div>
                            </td>
                            @if(auth()->user()->hasAdminAccess())
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 animate-pulse shrink-0"></div>
                                        <div class="flex flex-col gap-1 w-24">
                                            <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                                            <div class="h-3 bg-gray-200 rounded animate-pulse"></div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            <td class="px-6 py-4">
                                <div class="h-4 bg-gray-200 rounded w-28 mb-1 animate-pulse"></div>
                                <div class="h-4 bg-gray-200 rounded w-12 animate-pulse"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="h-4 bg-gray-200 rounded w-24 animate-pulse"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="h-6 bg-gray-200 rounded-full w-20 animate-pulse"></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="h-8 w-8 bg-gray-200 rounded animate-pulse"></div>
                                    <div class="h-8 w-8 bg-gray-200 rounded animate-pulse"></div>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $solicitudes->links() }}
        </div>
    </div>

    <!-- Modal de Acción (Glassmorphism) -->
    @if($actionModalVisible)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    @if($pendingAction === 'aprobar')
                        Aprobar y procesar solicitud
                    @elseif($pendingAction === 'rechazar')
                        Rechazar solicitud
                    @elseif($pendingAction === 'entregar')
                        Registrar Entrega
                    @endif
                </h3>
                
                <p class="text-sm text-gray-500 mb-6">
                    @if($pendingAction === 'aprobar')
                        Estás a punto de pasar esta solicitud a "En proceso". Puedes dejar una nota indicando tiempos de espera o instrucciones.
                    @elseif($pendingAction === 'rechazar')
                        Indica la razón por la que esta solicitud es rechazada para que el usuario esté informado.
                    @elseif($pendingAction === 'entregar')
                        Sube una foto del recibo firmado o del equipo entregado como evidencia (Obligatorio).
                    @endif
                </p>

                @if($pendingAction === 'aprobar' || $pendingAction === 'rechazar')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nota para el usuario (Opcional)</label>
                        <textarea wire:model="adminNote" rows="3" class="input-suraki w-full" placeholder="Ej. El equipo llegará en 3 días..."></textarea>
                        @error('adminNote') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @elseif($pendingAction === 'entregar')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Evidencia (Foto/Recibo) *</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg transition-colors cursor-pointer" 
                             x-data="{ isDropping: false }"
                             x-on:dragover.prevent="isDropping = true"
                             x-on:dragleave.prevent="isDropping = false"
                             x-on:drop.prevent="isDropping = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));"
                             x-bind:class="{ 'border-suraki-primary bg-suraki-primary/5': isDropping, 'hover:border-suraki-primary': !isDropping }"
                             onclick="document.getElementById('file-upload').click()">
                            <div class="space-y-1 text-center pointer-events-none">
                                @if($proofPhoto)
                                    <div class="text-sm text-green-600 font-semibold mb-2">
                                        <svg class="mx-auto h-8 w-8 text-green-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Imagen seleccionada lista
                                    </div>
                                @else
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span class="relative rounded-md font-medium text-suraki-primary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-suraki-primary">
                                            <span>Sube un archivo</span>
                                        </span>
                                        <p class="pl-1">o arrástralo y suéltalo</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG hasta 5MB</p>
                                @endif
                            </div>
                            <input id="file-upload" x-ref="fileInput" wire:model="proofPhoto" type="file" class="sr-only" accept="image/*">
                        </div>
                        <div wire:loading wire:target="proofPhoto" class="text-sm text-blue-500 mt-2 font-medium">Cargando archivo...</div>
                        @error('proofPhoto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nota adicional de entrega (Opcional)</label>
                        <textarea wire:model="deliveryNote" rows="2" class="input-suraki w-full" placeholder="Detalles de la entrega..."></textarea>
                        @error('deliveryNote') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                <button wire:click="closeActionModal" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <x-btn-panel wire:click="confirmAction" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="confirmAction">Confirmar</span>
                    <span wire:loading wire:target="confirmAction">Procesando...</span>
                </x-btn-panel>
            </div>
        </div>
    </div>
    @endif

    <!-- Slide-over / Timeline de la Solicitud -->
    @if($detailModalVisible && $selectedRequest)
    <div class="fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" wire:click="closeDetailModal"></div>
        <div class="fixed inset-y-0 right-0 max-w-md w-full flex">
            <div class="w-full h-full bg-white shadow-2xl flex flex-col transform transition-transform border-l border-gray-100">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h2 class="text-lg font-bold text-gray-900">Detalles de Solicitud #{{ $selectedRequest->id }}</h2>
                    <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6 space-y-6">
                    <!-- Basic Info -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-suraki-primary/10 flex items-center justify-center text-suraki-primary font-bold">
                                {{ substr($selectedRequest->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $selectedRequest->user->name ?? 'N/A' }}</h4>
                                <p class="text-xs text-gray-500">{{ $selectedRequest->user->department->name ?? 'Sin departamento' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 block text-xs">Equipo</span>
                                <span class="font-medium text-gray-900">{{ $selectedRequest->device_type }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-xs">Asignado a</span>
                                <span class="font-medium text-gray-900">{{ $selectedRequest->assignedTo->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="mt-4 text-sm">
                            <span class="text-gray-500 block text-xs mb-1">Descripción de la necesidad</span>
                            <p class="text-gray-800 bg-white p-3 rounded border border-gray-200">{{ $selectedRequest->description }}</p>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4">Proceso de la Solicitud</h3>
                        <div class="relative pl-4 space-y-6 border-l-2 border-gray-200 ml-2">
                            
                            <!-- Step 1: Created -->
                            <div class="relative">
                                <span class="absolute -left-6 bg-gray-200 w-4 h-4 rounded-full border-4 border-white"></span>
                                <div class="ml-2">
                                    <h4 class="text-sm font-bold text-gray-900">Solicitud Creada</h4>
                                    <p class="text-xs text-gray-500">{{ $selectedRequest->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <!-- Step 2: En Proceso / Rechazado -->
                            @if($selectedRequest->status !== 'pendiente')
                                <div class="relative">
                                    @php
                                        $iconColor = $selectedRequest->status === 'rechazado' ? 'bg-red-500' : 'bg-blue-500';
                                        $title = $selectedRequest->status === 'rechazado' ? 'Solicitud Rechazada' : 'En Proceso (Aprobado)';
                                    @endphp
                                    <span class="absolute -left-6 {{ $iconColor }} w-4 h-4 rounded-full border-4 border-white"></span>
                                    <div class="ml-2">
                                        <h4 class="text-sm font-bold text-gray-900">{{ $title }}</h4>
                                        <p class="text-xs text-gray-500 mb-2">Revisado por el equipo IT</p>
                                        @if($selectedRequest->admin_note)
                                            <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded-r-md text-sm text-blue-800">
                                                <span class="font-semibold block mb-1">Nota del Administrador:</span>
                                                {{ $selectedRequest->admin_note }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Step 3: Entregado -->
                            @if($selectedRequest->status === 'entregado')
                                <div class="relative">
                                    <span class="absolute -left-6 bg-green-500 w-4 h-4 rounded-full border-4 border-white"></span>
                                    <div class="ml-2">
                                        <h4 class="text-sm font-bold text-gray-900">Equipo Entregado</h4>
                                        <p class="text-xs text-gray-500 mb-2">El proceso ha concluido exitosamente el {{ $selectedRequest->delivered_at ? $selectedRequest->delivered_at->format('d M Y, H:i') : '' }}.</p>
                                        
                                        @if($selectedRequest->delivered_at)
                                        <div class="inline-block bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded mb-3">
                                            Tiempo de resolución: {{ $selectedRequest->created_at->diffForHumans($selectedRequest->delivered_at, true) }}
                                        </div>
                                        @endif

                                        @if($selectedRequest->delivery_note)
                                            <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded-r-md text-sm text-green-800 mb-3">
                                                <span class="font-semibold block mb-1">Nota de entrega:</span>
                                                {{ $selectedRequest->delivery_note }}
                                            </div>
                                        @endif

                                        @if($selectedRequest->proof_photo_path)
                                            <div class="mt-3">
                                                <span class="text-xs font-semibold text-gray-600 block mb-1">Evidencia de entrega:</span>
                                                <a href="{{ asset('storage/' . $selectedRequest->proof_photo_path) }}" target="_blank" class="block overflow-hidden rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition">
                                                    <img src="{{ asset('storage/' . $selectedRequest->proof_photo_path) }}" alt="Evidencia" class="w-full h-32 object-cover">
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                        </div>
                    </div>
                    
                    <!-- Historial y Comunicaciones (Chat) -->
                    @if($selectedRequest->status !== 'pendiente' && $selectedRequest->status !== 'rechazado')
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4">Comunicaciones</h3>
                        
                        <div class="space-y-4 mb-4">
                            @forelse($selectedRequest->comments as $comment)
                                @php
                                    $isMine = $comment->user_id === auth()->id();
                                @endphp
                                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[85%] {{ $isMine ? 'bg-suraki-primary text-white rounded-l-xl rounded-tr-xl' : 'bg-gray-100 text-gray-800 rounded-r-xl rounded-tl-xl' }} px-4 py-2 shadow-sm text-sm">
                                        @if(!$isMine)
                                            <span class="block text-xs font-bold text-gray-500 mb-1">{{ $comment->user->name ?? 'Usuario' }}</span>
                                        @endif
                                        <p>{{ $comment->body }}</p>
                                        <span class="block text-[10px] {{ $isMine ? 'text-blue-100' : 'text-gray-400' }} text-right mt-1">{{ $comment->created_at->format('d M H:i') }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic text-center">No hay mensajes aún.</p>
                            @endforelse
                        </div>

                        @php
                            $user = auth()->user();
                            $isAdmin = $user->hasAdminAccess();
                            $daysSinceCreation = $selectedRequest->created_at->diffInDays(now());
                            $hasComments = $selectedRequest->comments->count() > 0;
                            $canComment = $isAdmin || ($daysSinceCreation >= 15) || $hasComments;
                        @endphp

                        @if($canComment && $selectedRequest->status !== 'entregado')
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-200">
                                <textarea wire:model="newCommentBody" rows="2" class="w-full text-sm border-gray-300 rounded-lg focus:ring-suraki-primary focus:border-suraki-primary resize-none" placeholder="Escribe un mensaje..."></textarea>
                                <div class="flex justify-end mt-2">
                                    <button wire:click="addComment" class="px-4 py-1.5 bg-suraki-primary text-white text-xs font-bold rounded-lg hover:bg-suraki-secondary transition-colors" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="addComment">Enviar</span>
                                        <span wire:loading wire:target="addComment">Enviando...</span>
                                    </button>
                                </div>
                                @error('newCommentBody') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        @elseif(!$isAdmin && $selectedRequest->status === 'en_proceso' && $daysSinceCreation < 15 && !$hasComments)
                            <div class="bg-blue-50 text-blue-800 p-3 rounded-lg text-xs text-center border border-blue-100">
                                Podrás solicitar un estado de avance o dejar una nota una vez que pasen 15 días desde la creación de la solicitud.
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
                
                <!-- Footer Slide-over (Eliminado por diseño) -->
            </div>
        </div>
    </div>
    @endif
</div>
