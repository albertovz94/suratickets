<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\Solicitud;

class SolicitudForm extends Component
{
    public $tipo_equipo = '';
    public $descripcion = '';

    protected $rules = [
        'tipo_equipo' => 'required|string|max:255',
        'descripcion' => 'required|string|min:10',
    ];

    public function save()
    {
        $this->validate();

        Solicitud::create([
            'user_id' => auth()->id(),
            'tipo_equipo' => $this->tipo_equipo,
            'descripcion' => $this->descripcion,
            'estado' => 'pendiente',
        ]);

        session()->flash('message', 'Tu solicitud ha sido enviada exitosamente.');

        return redirect()->route('solicitudes.index');
    }

    public function render()
    {
        return view('livewire.solicitudes.solicitud-form')->layout('layouts.app');
    }
}
