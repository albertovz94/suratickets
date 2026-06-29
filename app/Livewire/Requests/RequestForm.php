<?php

namespace App\Livewire\Requests;

use Livewire\Component;
use App\Models\EquipmentRequest;

class RequestForm extends Component
{
    public $step = 1;
    public $device_type = '';
    public $urgency = '';
    public $assigned_to = null;
    public $description = '';

    protected $messages = [
        'description.min' => 'La justificación debe ser más detallada (mínimo 10 caracteres).',
        'assigned_to.required' => 'Debes seleccionar a un técnico Outsourcing.',
    ];

    protected function rules()
    {
        if ($this->step == 1) {
            return [
                'device_type' => 'required|string|max:255',
                'urgency' => 'required|in:baja,media,alta,critica',
            ];
        }

        if ($this->step == 2) {
            return [
                'assigned_to' => 'required|exists:users,id',
            ];
        }

        if ($this->step == 3) {
            return [
                'description' => 'required|string|min:10',
            ];
        }

        return [
            'device_type' => 'required|string|max:255',
            'urgency' => 'required|in:baja,media,alta,critica',
            'assigned_to' => 'required|exists:users,id',
            'description' => 'required|string|min:10',
        ];
    }

    public function nextStep()
    {
        $this->validate();
        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function save()
    {
        $this->validate();

        EquipmentRequest::create([
            'user_id' => auth()->id(),
            'device_type' => $this->device_type,
            'urgency' => $this->urgency,
            'assigned_to' => $this->assigned_to,
            'description' => $this->description,
            'status' => 'pendiente',
        ]);

        session()->flash('message', 'Tu solicitud ha sido enviada exitosamente.');

        return redirect()->route('requests.index');
    }

    public function render()
    {
        $outsourcingUsers = \App\Models\User::where('role', 'outsourcing')->get();
        return view('livewire.requests.request-form', compact('outsourcingUsers'))->layout('layouts.app');
    }
}
