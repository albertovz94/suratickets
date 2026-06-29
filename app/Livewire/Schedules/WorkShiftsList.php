<?php

namespace App\Livewire\Schedules;

use Livewire\Component;
use App\Models\WorkShift;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;

class WorkShiftsList extends Component
{
    public $user_id;
    public $date;
    public $scheduled_start;
    public $scheduled_end;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date|after_or_equal:today',
        'scheduled_start' => 'nullable|date_format:H:i',
        'scheduled_end' => 'nullable|date_format:H:i|after:scheduled_start',
    ];

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
        if (!auth()->user()->hasAdminAccess()) {
            $this->user_id = auth()->id();
        }
    }

    public function createShift()
    {
        $this->validate();

        if ($this->scheduled_end && $this->scheduled_end > '22:30') {
            $this->addError('scheduled_end', 'La hora de fin máxima permitida es 22:30.');
            return;
        }

        // Verificar permisos
        if (!auth()->user()->hasAdminAccess() && $this->user_id != auth()->id()) {
            abort(403);
        }

        WorkShift::create([
            'user_id' => $this->user_id,
            'date' => $this->date,
            'scheduled_start' => $this->scheduled_start,
            'scheduled_end' => $this->scheduled_end,
            'status' => 'programado',
        ]);

        $this->reset(['scheduled_start', 'scheduled_end']);
        $this->dispatch('notify', message: 'Turno programado exitosamente.');
    }

    public function checkIn($shiftId)
    {
        $shift = WorkShift::findOrFail($shiftId);
        
        if (!auth()->user()->hasAdminAccess() && $shift->user_id !== auth()->id()) {
            abort(403);
        }

        $shift->update([
            'check_in' => now(),
            'status' => 'en_curso'
        ]);
        
        $this->dispatch('notify', message: 'Check-in registrado.');
    }

    public function checkOut($shiftId)
    {
        $shift = WorkShift::findOrFail($shiftId);
        
        if (!auth()->user()->hasAdminAccess() && $shift->user_id !== auth()->id()) {
            abort(403);
        }

        $shift->update([
            'check_out' => now(),
            'status' => 'completado'
        ]);
        
        $this->dispatch('notify', message: 'Check-out registrado.');
    }

    public function updateStatus($shiftId, $status)
    {
        if (!auth()->user()->hasAdminAccess()) {
            abort(403);
        }

        $shift = WorkShift::findOrFail($shiftId);
        $shift->update(['status' => $status]);
    }

    public function render()
    {
        $users = User::where('role', 'outsourcing')->get();
        $sistemasDept = Department::where('name', 'like', '%Sistemas%')->first();

        $query = WorkShift::with('user')->orderBy('date', 'desc')->orderBy('scheduled_start', 'asc');

        if (!auth()->user()->hasAdminAccess()) {
            $query->where('user_id', auth()->id());
        } else {
            // Filtrar solo los de sistemas si es admin
            if ($sistemasDept) {
                $query->whereHas('user', function($q) use ($sistemasDept) {
                    $q->where('department_id', $sistemasDept->id);
                });
            }
        }

        return view('livewire.schedules.work-shifts-list', [
            'outsourcing_users' => $users,
            'shifts' => $query->paginate(20)
        ])->layout('layouts.app');
    }
}
