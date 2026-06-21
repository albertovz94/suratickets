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

    public function setPeriod($period)
    {
        $this->period = $period;
        $this->resetPage();
        $this->loadData();
    }

    public function loadData()
    {
        $query = Ticket::with(['departamento']);

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

        $allTickets = $query->get();

        $this->metrics = [
            'total' => $allTickets->count(),
            'resueltos' => $allTickets->whereIn('status', ['resuelto', 'cerrado'])->count(),
            'pendientes' => $allTickets->whereNotIn('status', ['resuelto', 'cerrado'])->count(),
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

        $tickets = $query->latest()->paginate(20);

        return view('livewire.reports.index', [
            'tickets' => $tickets,
        ])->layout('layouts.app');
    }
}
