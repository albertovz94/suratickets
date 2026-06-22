<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\User;
use App\Models\Departamento;
use Carbon\Carbon;

class HorariosList extends Component
{
    public function render()
    {
        // Get IT department users
        $sistemasDept = Departamento::where('nombre', 'like', '%Sistemas%')->first();
        
        $users = [];
        if ($sistemasDept) {
            $users = User::where('departamento_id', $sistemasDept->id)
                ->with(['schedule', 'workShifts' => function($query) {
                    $query->whereDate('date', Carbon::today());
                }])
                ->get()
                ->map(function ($user) {
                    $user->is_working_now = $user->isWorkingNow();
                    return $user;
                });
        }

        return view('livewire.horarios.horarios-list', [
            'users' => $users
        ])->layout('layouts.app');
    }
}
