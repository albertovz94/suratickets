<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\WorkShift;
use App\Models\User;
use App\Models\Departamento;
use Carbon\Carbon;

class WorkShiftsList extends Component
{
    public $user_id;
    public $date;
    public $scheduled_start;
    public $scheduled_end;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date',
        'scheduled_start' => 'nullable|date_format:H:i',
        'scheduled_end' => 'nullable|date_format:H:i|after:scheduled_start',
    ];

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
        if (auth()->user()->rol !== 'admin') {
            $this->user_id = auth()->id();
        }
    }

    public function createShift()
    {
        $this->validate();

        // Verificar permisos
        if (auth()->user()->rol !== 'admin' && $this->user_id != auth()->id()) {
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
        session()->flash('message', 'Turno programado exitosamente.');
    }

    public function checkIn($shiftId)
    {
        $shift = WorkShift::findOrFail($shiftId);
        
        if (auth()->user()->rol !== 'admin' && $shift->user_id !== auth()->id()) {
            abort(403);
        }

        $shift->update([
            'check_in' => now(),
            'status' => 'en_curso'
        ]);
        
        session()->flash('message', 'Check-in registrado.');
    }

    public function checkOut($shiftId)
    {
        $shift = WorkShift::findOrFail($shiftId);
        
        if (auth()->user()->rol !== 'admin' && $shift->user_id !== auth()->id()) {
            abort(403);
        }

        $shift->update([
            'check_out' => now(),
            'status' => 'completado'
        ]);
        
        session()->flash('message', 'Check-out registrado.');
    }

    public function updateStatus($shiftId, $status)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $shift = WorkShift::findOrFail($shiftId);
        $shift->update(['status' => $status]);
    }

    public function render()
    {
        $sistemasDept = Departamento::where('nombre', 'like', '%Sistemas%')->first();
        $users = $sistemasDept ? User::where('departamento_id', $sistemasDept->id)->whereHas('schedule', function($q) {
            $q->where('type', 'outsourcing');
        })->get() : [];

        $query = WorkShift::with('user')->orderBy('date', 'desc')->orderBy('scheduled_start', 'asc');

        if (auth()->user()->rol !== 'admin') {
            $query->where('user_id', auth()->id());
        } else {
            // Filtrar solo los de sistemas si es admin
            if ($sistemasDept) {
                $query->whereHas('user', function($q) use ($sistemasDept) {
                    $q->where('departamento_id', $sistemasDept->id);
                });
            }
        }

        return view('livewire.horarios.work-shifts-list', [
            'outsourcing_users' => $users,
            'shifts' => $query->paginate(20)
        ])->layout('layouts.app');
    }
}
