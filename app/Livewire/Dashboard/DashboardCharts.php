<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class DashboardCharts extends Component
{
    public $timeFilter = 'month'; // 'day', 'week', 'month'

    public function mount()
    {
        // Default is month
    }

    public function setTimeFilter($filter)
    {
        $this->timeFilter = $filter;
        $this->dispatch('update-charts', data: $this->getChartData());
    }

    public function getChartData()
    {
        $user = Auth::user();
        $baseQuery = Ticket::query();

        if ($user->rol !== 'admin') {
            $baseQuery->where('creator_id', $user->id);
        }

        $labels = [];
        $totalData = [];
        $openData = [];
        $resolvedData = [];

        if ($this->timeFilter === 'month') {
            $labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            $totalData = array_fill(0, 12, 0);
            $openData = array_fill(0, 12, 0);
            $resolvedData = array_fill(0, 12, 0);

            $stats = (clone $baseQuery)
                ->whereYear('created_at', date('Y'))
                ->selectRaw('MONTH(created_at) as month, count(*) as total, sum(case when status = "abierto" then 1 else 0 end) as open_count, sum(case when status in ("resuelto", "cerrado") then 1 else 0 end) as resolved_count')
                ->groupBy('month')
                ->get();

            foreach ($stats as $stat) {
                $idx = $stat->month - 1;
                $totalData[$idx] = (int)$stat->total;
                $openData[$idx] = (int)$stat->open_count;
                $resolvedData[$idx] = (int)$stat->resolved_count;
            }
        } elseif ($this->timeFilter === 'week') {
            // Last 7 days
            for ($i = 6; $i >= 0; $i--) {
                $labels[] = Carbon::now()->subDays($i)->format('d/m');
            }
            $totalData = array_fill(0, 7, 0);
            $openData = array_fill(0, 7, 0);
            $resolvedData = array_fill(0, 7, 0);

            $stats = (clone $baseQuery)
                ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
                ->selectRaw('DATE(created_at) as date, count(*) as total, sum(case when status = "abierto" then 1 else 0 end) as open_count, sum(case when status in ("resuelto", "cerrado") then 1 else 0 end) as resolved_count')
                ->groupBy('date')
                ->get();

            foreach ($stats as $stat) {
                $dateFormatted = Carbon::parse($stat->date)->format('d/m');
                $idx = array_search($dateFormatted, $labels);
                if ($idx !== false) {
                    $totalData[$idx] = (int)$stat->total;
                    $openData[$idx] = (int)$stat->open_count;
                    $resolvedData[$idx] = (int)$stat->resolved_count;
                }
            }
        } elseif ($this->timeFilter === 'day') {
            // Hours of today (0-23) grouped by 4 hours
            $labels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'];
            $totalData = array_fill(0, 6, 0);
            $openData = array_fill(0, 6, 0);
            $resolvedData = array_fill(0, 6, 0);

            $stats = (clone $baseQuery)
                ->whereDate('created_at', Carbon::today())
                ->selectRaw('FLOOR(HOUR(created_at) / 4) as time_group, count(*) as total, sum(case when status = "abierto" then 1 else 0 end) as open_count, sum(case when status in ("resuelto", "cerrado") then 1 else 0 end) as resolved_count')
                ->groupBy('time_group')
                ->get();

            foreach ($stats as $stat) {
                $idx = (int)$stat->time_group;
                if ($idx >= 0 && $idx < 6) {
                    $totalData[$idx] = (int)$stat->total;
                    $openData[$idx] = (int)$stat->open_count;
                    $resolvedData[$idx] = (int)$stat->resolved_count;
                }
            }
        }

        return [
            'labels' => $labels,
            'total' => $totalData,
            'open' => $openData,
            'resolved' => $resolvedData
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-charts', [
            'initialData' => $this->getChartData()
        ]);
    }
}
