<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-heading font-bold text-2xl text-suraki-secondary leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-suraki-tertiary mt-1">Bienvenido/a de nuevo, {{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('tickets.create') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-suraki-primary text-white rounded-lg text-sm font-semibold hover:bg-suraki-primary-hover transition-all duration-200 shadow-sm shadow-suraki-primary/20">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nuevo Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Stats -->
            @php
                $user = auth()->user();
                $baseQuery = \App\Models\Ticket::query();
                if ($user->rol !== 'admin') {
                    $baseQuery->where('creator_id', $user->id);
                }

                $totalTickets = (clone $baseQuery)->count();
                $openTickets = (clone $baseQuery)->where('status', 'abierto')->count();
                $resolvedTickets = (clone $baseQuery)->whereIn('status', ['resuelto', 'cerrado'])->count();

                // Datos para Gráfica Mensual
                $monthlyDataRaw = (clone $baseQuery)
                    ->selectRaw('MONTH(created_at) as month, count(*) as count')
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('month')
                    ->pluck('count', 'month')
                    ->toArray();
                
                $monthlyData = [];
                for ($i = 1; $i <= 12; $i++) {
                    $monthlyData[] = $monthlyDataRaw[$i] ?? 0;
                }

                // Todos los departamentos existentes
                $allDepartments = \App\Models\Departamento::pluck('nombre')->toArray();

                // Datos para Gráfica de Distribución
                $distributionRaw = (clone $baseQuery)
                    ->join('departamentos', 'tickets.departamento_id', '=', 'departamentos.id')
                    ->selectRaw('departamentos.nombre as departamento_nombre, count(tickets.id) as count')
                    ->groupBy('departamentos.nombre')
                    ->pluck('count', 'departamento_nombre')
                    ->toArray();

                $distLabels = [];
                $distData = [];
                
                foreach ($allDepartments as $dept) {
                    $count = $distributionRaw[$dept] ?? 0;
                    // Mostrar solo departamentos con tickets para "los que generan mas tickets"
                    // o mostrarlos todos si se desea. El requerimiento dice "deben verse los departamentos existentes y colocar los que generan mas tickets".
                    $distLabels[] = $dept;
                    $distData[] = $count;
                }

                // Ordenar de mayor a menor para "colocar los departamentos que generan mas tickets"
                array_multisort($distData, SORT_DESC, $distLabels);

                $colors = ['#b91c1c', '#1f2937', '#9ca3af', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899'];

                // Rendimiento de Sistemas
                $agents = collect();
                if ($user->rol === 'admin') {
                    $agents = \App\Models\User::withCount([
                        'assignedTickets as resolved_count' => function ($query) {
                            $query->whereIn('status', ['resuelto', 'cerrado']);
                        },
                        'assignedTickets as open_count' => function ($query) {
                            $query->where('status', 'abierto');
                        }
                    ])->orderByDesc('resolved_count')
                      ->take(5)
                      ->get();
                }
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card-suraki p-6 flex items-center gap-4 border-l-4" style="border-left-color: #eab308;">
                    <div class="p-3 rounded-full" style="background-color: #fef9c3; color: #ca8a04;">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-suraki-tertiary">Total de Tickets</p>
                        <p class="text-2xl font-bold font-mono text-suraki-secondary">{{ $totalTickets }}</p>
                    </div>
                </div>

                <div class="card-suraki p-6 flex items-center gap-4 border-l-4 border-l-suraki-primary">
                    <div class="p-3 bg-suraki-primary-light rounded-full text-suraki-primary">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-suraki-tertiary">Abiertos (Atención Requerida)</p>
                        <p class="text-2xl font-bold font-mono text-suraki-secondary">{{ $openTickets }}</p>
                    </div>
                </div>

                <div class="card-suraki p-6 flex items-center gap-4 border-l-4" style="border-left-color: #10b981;">
                    <div class="p-3 rounded-full" style="background-color: #d1fae5; color: #059669;">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-suraki-tertiary">Tickets Resueltos</p>
                        <p class="text-2xl font-bold font-mono text-suraki-secondary">{{ $resolvedTickets }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Tendencia Chart (2/3 width) -->
                <div class="lg:col-span-2 card-suraki p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Tendencia de Tickets Mensuales</h3>
                        <span class="text-xs text-suraki-tertiary font-mono bg-suraki-neutral px-3 py-1 rounded-md">{{ date('Y') }} - Año Actual</span>
                    </div>
                    <div class="relative h-72" wire:ignore>
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Distribución Chart (1/3 width) -->
                <div class="card-suraki p-6 flex flex-col items-center relative">
                    <h3 class="text-lg font-heading font-semibold text-suraki-secondary mb-6 self-start">Distribución</h3>
                    
                    <div class="relative w-48 h-48 mb-6" wire:ignore>
                        <canvas id="distChart"></canvas>
                        <!-- Center Text -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold font-mono text-suraki-secondary">{{ collect($distData)->sum() >= 1000 ? number_format(collect($distData)->sum() / 1000, 1) . 'k' : collect($distData)->sum() }}</span>
                            <span class="text-xs text-suraki-tertiary uppercase font-bold tracking-wider">Total</span>
                        </div>
                    </div>

                    <!-- Custom Legend -->
                    <div class="w-full space-y-3 mt-auto">
                        @foreach($distLabels as $index => $label)
                            @php
                                $percentage = collect($distData)->sum() > 0 ? round(($distData[$index] / collect($distData)->sum()) * 100) : 0;
                            @endphp
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $colors[$index % count($colors)] }};"></span>
                                    <span class="text-sm font-medium text-suraki-secondary">{{ $label }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-mono text-suraki-tertiary">{{ $distData[$index] }} tkts</span>
                                    <span class="text-sm font-bold text-suraki-secondary">{{ $percentage }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Rendimiento de Sistemas -->
            @if($user->rol === 'admin')
            <div class="card-suraki p-0 overflow-hidden mt-8 col-span-full">
                <div class="p-6 border-b border-suraki-neutral flex justify-between items-center bg-suraki-neutral/30">
                    <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Rendimiento de Sistemas</h3>
                    <a href="#" class="text-sm font-medium text-suraki-primary hover:text-suraki-primary-hover hover:underline transition-colors">Ver reporte completo</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-suraki-neutral/50 border-b border-suraki-neutral text-xs font-bold text-suraki-tertiary uppercase tracking-wider">
                                <th class="px-6 py-4">Agente</th>
                                <th class="px-6 py-4">Tickets Resueltos</th>
                                <th class="px-6 py-4 text-right">Estatus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-suraki-neutral">
                            @foreach($agents as $agent)
                                <tr class="hover:bg-suraki-neutral/20 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 shrink-0 rounded-full border border-suraki-neutral-dark bg-suraki-neutral flex items-center justify-center text-suraki-primary font-bold shadow-sm overflow-hidden">
                                                @if($agent->avatar_path)
                                                    <img src="{{ $agent->avatar_path }}" class="w-full h-full object-cover" alt="Avatar">
                                                @else
                                                    {{ substr($agent->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-suraki-secondary">{{ $agent->name }}</p>
                                                <p class="text-xs text-suraki-tertiary font-mono">{{ optional($agent->departamento)->nombre ?? 'Sin departamento' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-lg font-bold font-mono text-suraki-secondary">{{ $agent->resolved_count }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($agent->open_count == 0)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                DISPONIBLE
                                            </span>
                                        @elseif($agent->open_count > 0 && $agent->open_count < 5)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                EN TAREA
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                OCUPADO
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if($agents->isEmpty())
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-sm text-suraki-tertiary">
                                        No hay agentes asignados con actividad.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Chart.js and Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" data-navigate-once></script>
    <script>
        document.addEventListener('livewire:navigated', function() {
            if (typeof Chart === 'undefined') return;

            const trendCanvas = document.getElementById('trendChart');
            const distCanvas = document.getElementById('distChart');
            
            if (!trendCanvas || !distCanvas) return; // Not on dashboard
            
            // Destroy existing charts if any
            if (window.trendChartInstance) window.trendChartInstance.destroy();
            if (window.distChartInstance) window.distChartInstance.destroy();

            // Data from PHP
            const monthlyData = @json($monthlyData);
            const distLabels = @json($distLabels);
            const distData = @json($distData);
            const palette = @json($colors);

            // 1. Tendencia Chart (Line)
            const trendCtx = trendCanvas.getContext('2d');
            
            // Create Gradient
            let gradient = trendCtx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(185, 28, 28, 0.2)'); // Red with opacity
            gradient.addColorStop(1, 'rgba(185, 28, 28, 0)');

            window.trendChartInstance = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Tickets',
                        data: monthlyData,
                        borderColor: '#b91c1c', // suraki-primary
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#b91c1c',
                        pointBorderWidth: 2,
                        pointRadius: 3, // Puntos visibles para mejor interacción
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Curved line
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleFont: { family: 'Hanken Grotesk', size: 14 },
                            bodyFont: { family: 'Inter', size: 13 },
                            displayColors: false,
                            callbacks: {
                                label: function(context) { return context.parsed.y + ' Tickets'; }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'JetBrains Mono', size: 11 }, color: '#6b7280', maxTicksLimit: 5 }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'Inter', size: 12 }, color: '#6b7280' }
                        }
                    }
                }
            });

            // 2. Distribución Chart (Doughnut)
            if(distLabels.length > 0) {
                const distCtx = distCanvas.getContext('2d');
                window.distChartInstance = new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: distLabels,
                        datasets: [{
                            data: distData,
                            backgroundColor: palette,
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { display: false }, // Custom legend used in HTML
                            tooltip: {
                                backgroundColor: '#1f2937',
                                padding: 10,
                                bodyFont: { family: 'Inter', size: 13 },
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.parsed + ' tickets';
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                // Si no hay datos, mostrar algo
                distCanvas.parentElement.innerHTML = '<div class="absolute inset-0 flex items-center justify-center text-sm text-gray-400">Sin datos</div>';
            }
        });
    </script>
</x-app-layout>
