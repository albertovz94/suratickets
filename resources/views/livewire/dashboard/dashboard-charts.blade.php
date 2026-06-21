<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h3 class="text-lg font-heading font-semibold text-suraki-secondary">Tendencias de Tickets</h3>
        
        <div class="flex bg-suraki-neutral p-1 rounded-lg">
            <button wire:click="setTimeFilter('day')" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $timeFilter === 'day' ? 'bg-white text-suraki-primary shadow-sm' : 'text-suraki-tertiary hover:text-suraki-secondary' }}">Hoy</button>
            <button wire:click="setTimeFilter('week')" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $timeFilter === 'week' ? 'bg-white text-suraki-primary shadow-sm' : 'text-suraki-tertiary hover:text-suraki-secondary' }}">Semana</button>
            <button wire:click="setTimeFilter('month')" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $timeFilter === 'month' ? 'bg-white text-suraki-primary shadow-sm' : 'text-suraki-tertiary hover:text-suraki-secondary' }}">Año</button>
        </div>
    </div>

    <div class="relative h-72" wire:ignore>
        <canvas id="interactiveTrendChart"></canvas>
    </div>

    @script
    <script>
        let interactiveChart;

        const initChart = (data) => {
            const ctx = document.getElementById('interactiveTrendChart');
            if(!ctx) return;

            if (typeof Chart === 'undefined') {
                setTimeout(() => initChart(data), 100);
                return;
            }

            if (interactiveChart) {
                interactiveChart.destroy();
            }

            interactiveChart = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Total',
                            data: data.total,
                            borderColor: '#b91c1c', // red
                            backgroundColor: 'rgba(185, 28, 28, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        },
                        {
                            label: 'Resueltos',
                            data: data.resolved,
                            borderColor: '#10b981', // green
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        },
                        {
                            label: 'Abiertos',
                            data: data.open,
                            borderColor: '#eab308', // yellow
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [2, 2],
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Poppins' }, usePointStyle: true, boxWidth: 8 } },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleFont: { family: 'Poppins', size: 14 },
                            bodyFont: { family: 'Poppins', size: 13 },
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'Poppins', size: 11 }, color: '#6b7280', precision: 0 }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'Poppins', size: 12 }, color: '#6b7280' }
                        }
                    }
                }
            });
        };

        // Initialize with initial data
        const initialData = @json($initialData);
        initChart(initialData);

        // Listen for updates
        $wire.on('update-charts', (event) => {
            // Livewire 3 passes the event payload directly, while Livewire 2 passed it in an array
            const chartData = event.data || (event[0] && event[0].data) || event;
            initChart(chartData);
        });
    </script>
    @endscript
</div>
