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
            
            for ($i = 1; $i <= 12; $i++) {
                $totalData[] = (clone $baseQuery)->whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->count();
                $openData[] = (clone $baseQuery)->whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->where('status', 'abierto')->count();
                $resolvedData[] = (clone $baseQuery)->whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->whereIn('status', ['resuelto', 'cerrado'])->count();
            }
        } elseif ($this->timeFilter === 'week') {
            // Last 7 days
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->format('d/m');
                
                $totalData[] = (clone $baseQuery)->whereDate('created_at', $date->toDateString())->count();
                $openData[] = (clone $baseQuery)->whereDate('created_at', $date->toDateString())->where('status', 'abierto')->count();
                $resolvedData[] = (clone $baseQuery)->whereDate('created_at', $date->toDateString())->whereIn('status', ['resuelto', 'cerrado'])->count();
            }
        } elseif ($this->timeFilter === 'day') {
            // Hours of today (0-23)
            for ($i = 0; $i <= 23; $i+=4) { // group by 4 hours to not crowd
                $labels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                
                $total = (clone $baseQuery)->whereDate('created_at', Carbon::today())
                    ->whereRaw('HOUR(created_at) >= ? AND HOUR(created_at) < ?', [$i, $i+4])->count();
                $open = (clone $baseQuery)->whereDate('created_at', Carbon::today())
                    ->where('status', 'abierto')
                    ->whereRaw('HOUR(created_at) >= ? AND HOUR(created_at) < ?', [$i, $i+4])->count();
                $resolved = (clone $baseQuery)->whereDate('created_at', Carbon::today())
                    ->whereIn('status', ['resuelto', 'cerrado'])
                    ->whereRaw('HOUR(created_at) >= ? AND HOUR(created_at) < ?', [$i, $i+4])->count();
                    
                $totalData[] = $total;
                $openData[] = $open;
                $resolvedData[] = $resolved;
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
