<?php

namespace App\Livewire\Schedules;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;

class ScheduleList extends Component
{
    public function render()
    {
        // Get IT department users
        $sistemasDept = Department::where('name', 'like', '%Sistemas%')->first();
        
        $users = [];
        if ($sistemasDept) {
            $users = User::where('department_id', $sistemasDept->id)
                ->with(['schedule', 'workShifts' => function($query) {
                    $query->whereDate('date', Carbon::today());
                }])
                ->get()
                ->map(function ($user) {
                    $user->is_working_now = $user->isWorkingNow();
                    return $user;
                });
        }

        return view('livewire.schedules.schedule-list', [
            'users' => $users
        ])->layout('layouts.app');
    }
}
