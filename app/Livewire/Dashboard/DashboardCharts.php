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
        $this->dispatch('update-charts', data: $this->getChartData(app(\App\Services\TicketStatsService::class)));
    }

    public function getChartData(\App\Services\TicketStatsService $statsService)
    {
        return $statsService->getDashboardChartsData($this->timeFilter);
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-charts', [
            'initialData' => $this->getChartData(app(\App\Services\TicketStatsService::class))
        ]);
    }
}
