<div class="space-y-6 pb-12">
    
    <!-- HEADER Y ACCIONES -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Reportes y Analíticas</h2>
            <p class="text-sm text-gray-500">Analiza el rendimiento y las incidencias del sistema.</p>
        </div>
        
        <div class="flex gap-2">
            <button onclick="exportToPDF()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-xl shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Exportar PDF
            </button>
        </div>
    </div>

    <!-- FILTROS DE TIEMPO -->
    <div class="bg-white rounded-xl shadow-sm border border-suraki-neutral-dark p-2 flex gap-2 overflow-x-auto">
        <button wire:click="setPeriod('diario')" class="px-6 py-2 rounded-lg font-semibold text-sm transition-colors whitespace-nowrap {{ $period === 'diario' ? 'bg-suraki-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Diario (Hoy)
        </button>
        <button wire:click="setPeriod('semanal')" class="px-6 py-2 rounded-lg font-semibold text-sm transition-colors whitespace-nowrap {{ $period === 'semanal' ? 'bg-suraki-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Semanal (7 Días)
        </button>
        <button wire:click="setPeriod('quincenal')" class="px-6 py-2 rounded-lg font-semibold text-sm transition-colors whitespace-nowrap {{ $period === 'quincenal' ? 'bg-suraki-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Quincenal (15 Días)
        </button>
        <button wire:click="setPeriod('mensual')" class="px-6 py-2 rounded-lg font-semibold text-sm transition-colors whitespace-nowrap {{ $period === 'mensual' ? 'bg-suraki-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Mensual (30 Días)
        </button>
    </div>

    <!-- TARJETAS DE MÉTRICAS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-suraki-neutral-dark flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Creados</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $metrics['total'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-suraki-neutral-dark flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Resueltos</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $metrics['resueltos'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-suraki-neutral-dark flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Pendientes</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $metrics['pendientes'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-suraki-neutral-dark flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Tiempo Promedio</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $metrics['avg_resolution_time'] ?? 'N/A' }}</h3>
            </div>
        </div>
    </div>

    <!-- GRÁFICOS INTERACTIVOS (Solo en pantalla, no se exportan) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-suraki-neutral-dark">
            <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Incidencias por Departamento</h3>
            <div wire:ignore>
                <div id="chart-departments"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-suraki-neutral-dark">
            <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Estado de las Incidencias</h3>
            <div wire:ignore>
                <div id="chart-status"></div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-suraki-neutral-dark">
        <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Top 5: Incidencias Más Comunes</h3>
        <div wire:ignore>
            <div id="chart-common"></div>
        </div>
    </div>

    <!-- TABLA DE DETALLES -->
    <div class="bg-white rounded-xl shadow-sm border border-suraki-neutral-dark overflow-hidden mt-6">
        <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-900 text-lg">Registro Detallado de Operaciones</h3>
            <p class="text-sm text-gray-500">Historial completo de lo abordado y resuelto en el periodo seleccionado.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-900 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Detalle del Ticket</th>
                        <th class="px-6 py-4 font-semibold">Involucrados</th>
                        <th class="px-6 py-4 font-semibold">Departamento & Estado</th>
                        <th class="px-6 py-4 font-semibold text-right">Fechas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900 text-base">#{{ $ticket->id }} - {{ $ticket->title }}</span>
                                    <span class="text-xs text-gray-500 mt-1 line-clamp-2 max-w-md" title="{{ $ticket->description }}">
                                        {{ Str::limit($ticket->description, 100) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1 text-xs">
                                    <div class="flex items-center gap-1">
                                        <span class="text-gray-400 font-semibold">De:</span> 
                                        <span class="font-medium text-gray-700">{{ $ticket->creator->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-gray-400 font-semibold">Para:</span> 
                                        <span class="font-medium text-gray-700">{{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Sin asignar' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-start gap-2">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-semibold">
                                        {{ $ticket->departamento ? $ticket->departamento->nombre : 'Sin depto' }}
                                    </span>
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                        {{ $ticket->status === 'resuelto' || $ticket->status === 'cerrado' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $ticket->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-gray-500">
                                <div class="flex flex-col gap-1 justify-end">
                                    <div><span class="font-semibold text-gray-400">Creado:</span> {{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                                    @if($ticket->status === 'resuelto' || $ticket->status === 'cerrado')
                                        <div class="text-green-600"><span class="font-semibold opacity-75">Resuelto:</span> {{ $ticket->updated_at->format('d/m/Y H:i') }}</div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">No hay tickets registrados en este periodo.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-gray-50/50">
            {{ $tickets->links() }}
        </div>
    </div>

    <!-- ============================================================= -->
    <!-- PDF DOCUMENT (Hidden - Solo se muestra al exportar)           -->
    <!-- Usa TABLAS puras HTML, sin gráficos canvas/svg                -->
    <!-- ============================================================= -->
    <div id="pdf-document" class="hidden">
        <div style="font-family: 'Helvetica Neue', Arial, sans-serif; color: #1a1a2e; padding: 30px; max-width: 750px; margin: 0 auto;">
            
            <!-- PDF Header -->
            <div style="text-align: center; border-bottom: 3px solid #dc2626; padding-bottom: 20px; margin-bottom: 25px;">
                <h1 style="font-size: 22px; font-weight: 800; color: #1a1a2e; margin: 0 0 5px 0;">REPORTE DE SISTEMA HELPDESK</h1>
                <p style="font-size: 12px; color: #6b7280; margin: 0 0 10px 0;">Sistema de Gestión de Tickets — Suraki</p>
                <div style="display: inline-block; background: #dc2626; color: white; padding: 6px 20px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 1px;">
                    PERIODO: {{ strtoupper($period) }}
                </div>
                <p style="font-size: 11px; color: #9ca3af; margin: 8px 0 0 0;">Generado: {{ now()->format('d/m/Y H:i') }} — Hora Venezuela (UTC-4)</p>
            </div>

            <!-- PDF KPI Cards -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
                <tr>
                    <td style="width: 25%; padding: 5px;">
                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 18px; text-align: center;">
                            <p style="font-size: 10px; font-weight: 700; color: #3b82f6; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 5px 0;">Creados</p>
                            <p style="font-size: 32px; font-weight: 800; color: #1e40af; margin: 0;">{{ $metrics['total'] }}</p>
                        </div>
                    </td>
                    <td style="width: 25%; padding: 5px;">
                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 18px; text-align: center;">
                            <p style="font-size: 10px; font-weight: 700; color: #16a34a; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 5px 0;">Resueltos</p>
                            <p style="font-size: 32px; font-weight: 800; color: #15803d; margin: 0;">{{ $metrics['resueltos'] }}</p>
                        </div>
                    </td>
                    <td style="width: 25%; padding: 5px;">
                        <div style="background: #fefce8; border: 1px solid #fde68a; border-radius: 10px; padding: 18px; text-align: center;">
                            <p style="font-size: 10px; font-weight: 700; color: #ca8a04; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 5px 0;">Pendientes</p>
                            <p style="font-size: 32px; font-weight: 800; color: #a16207; margin: 0;">{{ $metrics['pendientes'] }}</p>
                        </div>
                    </td>
                    <td style="width: 25%; padding: 5px;">
                        <div style="background: #f3e8ff; border: 1px solid #e9d5ff; border-radius: 10px; padding: 18px; text-align: center;">
                            <p style="font-size: 10px; font-weight: 700; color: #9333ea; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 5px 0;">Tiempo (SLA)</p>
                            <p style="font-size: 32px; font-weight: 800; color: #6b21a8; margin: 0;">{{ $metrics['avg_resolution_time'] ?? 'N/A' }}</p>
                        </div>
                    </td>
                </tr>
            </table>

            @if($metrics['total'] > 0)
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 8px;">
                    <tr>
                        <td style="width: 100%; padding: 0;">
                            <div style="background: #f3f4f6; border-radius: 8px; height: 12px; overflow: hidden;">
                                @php 
                                    $pctRes = $metrics['total'] > 0 ? round(($metrics['resueltos'] / $metrics['total']) * 100) : 0;
                                @endphp
                                <div style="background: linear-gradient(90deg, #16a34a, #22c55e); height: 12px; width: {{ $pctRes }}%; border-radius: 8px;"></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <p style="font-size: 10px; color: #6b7280; text-align: center; margin: 0 0 25px 0;">
                    Tasa de resolución: <strong style="color: #16a34a;">{{ $pctRes }}%</strong> de los tickets fueron resueltos en este periodo.
                </p>
            @endif

            <!-- PDF: Estadísticas por Departamento & Estado (side by side) -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                        <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden;">
                            <div style="background: #1e40af; color: white; padding: 10px 15px;">
                                <p style="font-size: 12px; font-weight: 700; margin: 0;">📊 Incidencias por Departamento</p>
                            </div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f8fafc;">
                                        <th style="padding: 8px 12px; text-align: left; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Departamento</th>
                                        <th style="padding: 8px 12px; text-align: center; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Cantidad</th>
                                        <th style="padding: 8px 12px; text-align: right; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($deptChart as $dept => $count)
                                        <tr>
                                            <td style="padding: 8px 12px; font-size: 11px; color: #1f2937; border-bottom: 1px solid #f3f4f6;">{{ $dept }}</td>
                                            <td style="padding: 8px 12px; font-size: 11px; color: #1f2937; text-align: center; font-weight: 700; border-bottom: 1px solid #f3f4f6;">{{ $count }}</td>
                                            <td style="padding: 8px 12px; font-size: 11px; color: #6b7280; text-align: right; border-bottom: 1px solid #f3f4f6;">{{ $metrics['total'] > 0 ? round(($count / $metrics['total']) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" style="padding: 15px; text-align: center; font-size: 11px; color: #9ca3af;">Sin datos</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                        <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden;">
                            <div style="background: #7c3aed; color: white; padding: 10px 15px;">
                                <p style="font-size: 12px; font-weight: 700; margin: 0;">📈 Estado de las Incidencias</p>
                            </div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f8fafc;">
                                        <th style="padding: 8px 12px; text-align: left; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Estado</th>
                                        <th style="padding: 8px 12px; text-align: center; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Cantidad</th>
                                        <th style="padding: 8px 12px; text-align: right; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($statusChart as $status => $count)
                                        <tr>
                                            <td style="padding: 8px 12px; font-size: 11px; border-bottom: 1px solid #f3f4f6;">
                                                <span style="display: inline-block; padding: 2px 10px; border-radius: 12px; font-weight: 700; font-size: 10px; text-transform: uppercase;
                                                    @if($status === 'resuelto' || $status === 'cerrado') background: #dcfce7; color: #15803d;
                                                    @elseif($status === 'abierto') background: #dbeafe; color: #1d4ed8;
                                                    @elseif($status === 'en_progreso') background: #fef9c3; color: #a16207;
                                                    @else background: #f3f4f6; color: #374151;
                                                    @endif
                                                ">{{ $status }}</span>
                                            </td>
                                            <td style="padding: 8px 12px; font-size: 11px; color: #1f2937; text-align: center; font-weight: 700; border-bottom: 1px solid #f3f4f6;">{{ $count }}</td>
                                            <td style="padding: 8px 12px; font-size: 11px; color: #6b7280; text-align: right; border-bottom: 1px solid #f3f4f6;">{{ $metrics['total'] > 0 ? round(($count / $metrics['total']) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" style="padding: 15px; text-align: center; font-size: 11px; color: #9ca3af;">Sin datos</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- PDF: Top 5 Incidencias Más Comunes -->
            <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; margin-bottom: 25px;">
                <div style="background: #ea580c; color: white; padding: 10px 15px;">
                    <p style="font-size: 12px; font-weight: 700; margin: 0;">🔥 Top 5: Incidencias Más Comunes</p>
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 8px 12px; text-align: center; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb; width: 40px;">#</th>
                            <th style="padding: 8px 12px; text-align: left; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Asunto del Ticket</th>
                            <th style="padding: 8px 12px; text-align: center; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">Repeticiones</th>
                            <th style="padding: 8px 12px; text-align: right; font-size: 10px; font-weight: 700; color: #374151; border-bottom: 1px solid #e5e7eb;">% del Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rank = 1; @endphp
                        @forelse($commonChart as $title => $count)
                            <tr>
                                <td style="padding: 8px 12px; text-align: center; font-size: 13px; font-weight: 800; color: {{ $rank <= 3 ? '#dc2626' : '#6b7280' }}; border-bottom: 1px solid #f3f4f6;">{{ $rank }}</td>
                                <td style="padding: 8px 12px; font-size: 11px; color: #1f2937; font-weight: 600; border-bottom: 1px solid #f3f4f6;">{{ $title }}</td>
                                <td style="padding: 8px 12px; font-size: 11px; color: #1f2937; text-align: center; font-weight: 700; border-bottom: 1px solid #f3f4f6;">{{ $count }}</td>
                                <td style="padding: 8px 12px; font-size: 11px; color: #6b7280; text-align: right; border-bottom: 1px solid #f3f4f6;">{{ $metrics['total'] > 0 ? round(($count / $metrics['total']) * 100, 1) : 0 }}%</td>
                            </tr>
                            @php $rank++; @endphp
                        @empty
                            <tr><td colspan="4" style="padding: 15px; text-align: center; font-size: 11px; color: #9ca3af;">Sin datos suficientes</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PDF: Detalle de Tickets -->
            <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; margin-bottom: 25px;">
                <div style="background: #1a1a2e; color: white; padding: 10px 15px;">
                    <p style="font-size: 12px; font-weight: 700; margin: 0;">📋 Registro Detallado de Operaciones</p>
                    <p style="font-size: 9px; color: #d1d5db; margin: 3px 0 0 0;">Historial completo de lo abordado y resuelto en el periodo.</p>
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 8px 10px; text-align: left; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">TICKET</th>
                            <th style="padding: 8px 10px; text-align: left; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">ASUNTO</th>
                            <th style="padding: 8px 10px; text-align: left; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">REPORTADO POR</th>
                            <th style="padding: 8px 10px; text-align: left; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">ATENDIDO POR</th>
                            <th style="padding: 8px 10px; text-align: left; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">DEPTO.</th>
                            <th style="padding: 8px 10px; text-align: center; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">ESTADO</th>
                            <th style="padding: 8px 10px; text-align: right; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">CREADO</th>
                            <th style="padding: 8px 10px; text-align: right; font-size: 9px; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb;">RESUELTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 7px 10px; font-size: 10px; font-weight: 700; color: #1e40af;">#{{ $ticket->id }}</td>
                                <td style="padding: 7px 10px; font-size: 10px; color: #1f2937; font-weight: 600;">{{ Str::limit($ticket->title, 30) }}</td>
                                <td style="padding: 7px 10px; font-size: 10px; color: #4b5563;">{{ $ticket->creator->name ?? 'N/A' }}</td>
                                <td style="padding: 7px 10px; font-size: 10px; color: #4b5563;">{{ $ticket->assignedTo ? $ticket->assignedTo->name : '—' }}</td>
                                <td style="padding: 7px 10px; font-size: 10px; color: #4b5563;">{{ $ticket->departamento ? $ticket->departamento->nombre : '—' }}</td>
                                <td style="padding: 7px 10px; text-align: center;">
                                    <span style="display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: 700; text-transform: uppercase;
                                        @if($ticket->status === 'resuelto' || $ticket->status === 'cerrado') background: #dcfce7; color: #15803d;
                                        @elseif($ticket->status === 'abierto') background: #dbeafe; color: #1d4ed8;
                                        @else background: #fef9c3; color: #a16207;
                                        @endif
                                    ">{{ $ticket->status }}</span>
                                </td>
                                <td style="padding: 7px 10px; font-size: 9px; color: #6b7280; text-align: right;">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                <td style="padding: 7px 10px; font-size: 9px; text-align: right; color: {{ $ticket->status === 'resuelto' || $ticket->status === 'cerrado' ? '#16a34a' : '#9ca3af' }};">
                                    {{ $ticket->status === 'resuelto' || $ticket->status === 'cerrado' ? $ticket->updated_at->format('d/m/Y H:i') : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" style="padding: 20px; text-align: center; font-size: 11px; color: #9ca3af;">No hay tickets registrados en este periodo.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PDF Footer -->
            <div style="border-top: 2px solid #e5e7eb; padding-top: 15px; text-align: center;">
                <p style="font-size: 9px; color: #9ca3af; margin: 0;">Este documento fue generado automáticamente por el Sistema HelpDesk de Suraki.</p>
                <p style="font-size: 9px; color: #9ca3af; margin: 3px 0 0 0;">Confidencial — Solo para uso interno. Fecha de impresión: {{ now()->format('d/m/Y H:i:s') }}</p>
            </div>

        </div>
    </div>

    <!-- SCRIPTS DE GRÁFICOS INTERACTIVOS -->
    @script
    <script>
        let chartDept, chartStatus, chartCommon;

        function initOrUpdateCharts() {
            const deptData = $wire.deptChart || {};
            const commonData = $wire.commonChart || {};
            const statusData = $wire.statusChart || {};

            // 1. Departamentos (Bar)
            const deptCategories = Object.keys(deptData);
            const deptSeries = [{ name: 'Incidencias', data: Object.values(deptData) }];
            
            if (chartDept) {
                chartDept.updateOptions({ xaxis: { categories: deptCategories } }, false, false);
                chartDept.updateSeries(deptSeries, true);
            } else {
                chartDept = new ApexCharts(document.querySelector("#chart-departments"), {
                    series: deptSeries,
                    chart: { type: 'bar', height: 320, toolbar: { show: false }, animations: { enabled: true, dynamicAnimation: { speed: 350 } } },
                    plotOptions: { bar: { borderRadius: 4, horizontal: true } },
                    dataLabels: { enabled: true, style: { colors: ['#fff'] } },
                    xaxis: { categories: deptCategories },
                    colors: ['#0284c7']
                });
                chartDept.render();
            }

            // 2. Status (Donut)
            const statusSeries = Object.values(statusData);
            const statusLabels = Object.keys(statusData).map(s => String(s).toUpperCase());
            
            if (chartStatus) {
                chartStatus.updateOptions({ labels: statusLabels }, false, false);
                chartStatus.updateSeries(statusSeries, true);
            } else {
                chartStatus = new ApexCharts(document.querySelector("#chart-status"), {
                    series: statusSeries,
                    labels: statusLabels,
                    chart: { type: 'donut', height: 320, animations: { enabled: true, dynamicAnimation: { speed: 350 } } },
                    colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#6b7280'],
                    legend: { position: 'bottom' }
                });
                chartStatus.render();
            }

            // 3. Comunes (Bar)
            const commonCategories = Object.keys(commonData);
            const commonSeries = [{ name: 'Repeticiones', data: Object.values(commonData) }];
            
            if (chartCommon) {
                chartCommon.updateOptions({ xaxis: { categories: commonCategories } }, false, false);
                chartCommon.updateSeries(commonSeries, true);
            } else {
                chartCommon = new ApexCharts(document.querySelector("#chart-common"), {
                    series: commonSeries,
                    chart: { type: 'bar', height: 320, toolbar: { show: false }, animations: { enabled: true, dynamicAnimation: { speed: 350 } } },
                    plotOptions: { bar: { borderRadius: 4, horizontal: false, columnWidth: '40%' } },
                    dataLabels: { enabled: true },
                    xaxis: { categories: commonCategories },
                    colors: ['#f59e0b']
                });
                chartCommon.render();
            }
        }

        initOrUpdateCharts();

        $wire.watch('deptChart', () => {
            initOrUpdateCharts();
        });
    </script>
    @endscript

    <!-- SCRIPT DE EXPORTACIÓN PDF (Usa el documento HTML oculto, NO los gráficos) -->
    <script>
        function exportToPDF() {
            const pdfSource = document.getElementById('pdf-document');
            
            // Clonar el contenido para no alterar el DOM original
            const clone = pdfSource.cloneNode(true);
            clone.classList.remove('hidden');
            clone.style.display = 'block';

            const opt = {
                margin:       [10, 8, 10, 8],
                filename:     'reporte-helpdesk-{{ $period }}-' + new Date().toISOString().slice(0,10) + '.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, width: 750 },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
            };

            html2pdf().set(opt).from(clone).save();
        }
    </script>
</div>
