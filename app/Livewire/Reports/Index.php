<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ticket;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $period = 'diario';
    public $metrics = ['total' => 0, 'resueltos' => 0, 'pendientes' => 0];
    public $deptChart = [];
    public $commonChart = [];
    public $statusChart = [];

    public function mount()
    {
        $this->loadData();
    }

    private function applyDateFilter($query)
    {
        $now = Carbon::now();
        switch ($this->period) {
            case 'diario':
                $query->where('created_at', '>=', $now->copy()->subDay());
                break;
            case 'semanal':
                $query->whereBetween('created_at', [$now->copy()->subDays(7), $now]);
                break;
            case 'quincenal':
                $query->whereBetween('created_at', [$now->copy()->subDays(15), $now]);
                break;
            case 'mensual':
                $query->whereBetween('created_at', [$now->copy()->subDays(30), $now]);
                break;
        }
        return $query;
    }

    public function setPeriod($period)
    {
        $this->period = $period;
        $this->resetPage();
        $this->loadData();
    }

    public function loadData()
    {
        $query = Ticket::with(['departamento']);
        $query = $this->applyDateFilter($query);

        $allTickets = $query->get();

        $resolvedTickets = $allTickets->filter(function($ticket) {
            return in_array($ticket->status, ['resuelto', 'cerrado']) && $ticket->resolved_at !== null;
        });

        $avgMinutes = 0;
        if ($resolvedTickets->count() > 0) {
            $totalMinutes = $resolvedTickets->reduce(function($carry, $ticket) {
                return $carry + $ticket->created_at->diffInMinutes($ticket->resolved_at);
            }, 0);
            $avgMinutes = $totalMinutes / $resolvedTickets->count();
        }

        $avgResolutionTime = $avgMinutes > 0 ? round($avgMinutes / 60, 1) . ' hrs' : 'N/A';

        $this->metrics = [
            'total' => $allTickets->count(),
            'resueltos' => $allTickets->whereIn('status', ['resuelto', 'cerrado'])->count(),
            'pendientes' => $allTickets->whereNotIn('status', ['resuelto', 'cerrado'])->count(),
            'avg_resolution_time' => $avgResolutionTime,
        ];

        $this->deptChart = $allTickets->groupBy(function($t) {
            return $t->departamento ? $t->departamento->nombre : 'Sin Depto';
        })->map->count()->toArray();

        $this->commonChart = $allTickets->groupBy('title')->map->count()->sortDesc()->take(5)->toArray();

        $this->statusChart = $allTickets->groupBy('status')->map->count()->toArray();
    }

    public function render()
    {
        $query = Ticket::with(['departamento', 'creator', 'assignedTo']);
        $query = $this->applyDateFilter($query);

        $tickets = $query->latest()->paginate(20);

        return view('livewire.reports.index', [
            'tickets' => $tickets,
        ])->layout('layouts.app');
    }
}
