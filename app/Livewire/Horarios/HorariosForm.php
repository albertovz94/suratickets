<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\User;
use App\Models\UserSchedule;
use App\Models\Departamento;

class HorariosForm extends Component
{
    public $user_id;
    public $type = 'fijo';
    
    // Horarios
    public $schedule = [
        'monday' => ['start' => '', 'end' => ''],
        'tuesday' => ['start' => '', 'end' => ''],
        'wednesday' => ['start' => '', 'end' => ''],
        'thursday' => ['start' => '', 'end' => ''],
        'friday' => ['start' => '', 'end' => ''],
        'saturday' => ['start' => '', 'end' => ''],
        'sunday' => ['start' => '', 'end' => ''],
    ];

    public function mount($id = null)
    {
        if (!auth()->user()->rol === 'admin') {
            abort(403);
        }

        if ($id) {
            $user = User::findOrFail($id);
            $this->user_id = $user->id;
            
            if ($user->schedule) {
                $this->type = $user->schedule->type;
                foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                    $startField = $day . '_start';
                    $endField = $day . '_end';
                    $this->schedule[$day]['start'] = $user->schedule->$startField ? substr($user->schedule->$startField, 0, 5) : '';
                    $this->schedule[$day]['end'] = $user->schedule->$endField ? substr($user->schedule->$endField, 0, 5) : '';
                }
            }
        }
    }

    public function save()
    {
        if (!auth()->user()->rol === 'admin') {
            abort(403);
        }

        $this->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:fijo,outsourcing',
        ]);

        $data = [
            'user_id' => $this->user_id,
            'type' => $this->type,
        ];

        if ($this->type === 'fijo') {
            foreach ($this->schedule as $day => $times) {
                $data[$day . '_start'] = !empty($times['start']) ? $times['start'] : null;
                $data[$day . '_end'] = !empty($times['end']) ? $times['end'] : null;
            }
        } else {
            // Outsourcing no tiene horario fijo
            foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                $data[$day . '_start'] = null;
                $data[$day . '_end'] = null;
            }
        }

        UserSchedule::updateOrCreate(
            ['user_id' => $this->user_id],
            $data
        );

        session()->flash('message', 'Horario actualizado exitosamente.');
        return redirect()->route('horarios.index');
    }

    public function render()
    {
        $sistemasDept = Departamento::where('nombre', 'like', '%Sistemas%')->first();
        $users = $sistemasDept ? User::where('departamento_id', $sistemasDept->id)->get() : [];

        return view('livewire.horarios.horarios-form', [
            'users' => $users
        ])->layout('layouts.app');
    }
}
