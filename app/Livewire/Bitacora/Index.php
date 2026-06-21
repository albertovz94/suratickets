<?php

namespace App\Livewire\Bitacora;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog;
use App\Models\RouteLog;

class Index extends Component
{
    use WithPagination;

    public $tab = 'acciones';

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        if ($this->tab === 'acciones') {
            $logs = ActivityLog::with('user')->latest()->paginate(20);
        } else {
            $logs = RouteLog::with('user')->latest()->paginate(20);
        }

        return view('livewire.bitacora.index', [
            'logs' => $logs
        ])->layout('layouts.app');
    }
}
