<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;

class TicketForm extends Component
{
    public $title = '';
    public $description = '';
    public $sucursal_id = '';
    public $area_departamento = '';
    public $equipo_afectado = '';
    public $priority = 'baja';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'sucursal_id' => 'required|exists:sucursales,id',
        'area_departamento' => 'required|string|max:255',
        'equipo_afectado' => 'required|string|max:255',
        'priority' => 'required|in:baja,media,alta,critica',
    ];

    public function mount()
    {
        if (Auth::user()->sucursal_id) {
            $this->sucursal_id = Auth::user()->sucursal_id;
        }
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['creator_id'] = Auth::id();
        $validatedData['status'] = 'abierto';

        Ticket::create($validatedData);

        session()->flash('message', 'Ticket creado exitosamente.');
        return $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.tickets.ticket-form', [
            'sucursales' => Sucursal::all()
        ])->layout('layouts.app');
    }
}
