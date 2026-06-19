<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Sucursal;
use App\Models\Departamento;
use Illuminate\Support\Facades\Auth;

class TicketForm extends Component
{
    public $title = '';
    public $description = '';
    public $sucursal_id = '';
    public $departamento_id = '';
    public $priority = 'baja';
    public $fecha_hora = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:2000',
        'sucursal_id' => 'required|exists:sucursales,id',
        'departamento_id' => 'required|exists:departamentos,id',
        'priority' => 'required|in:baja,media,alta,critica',
    ];

    public function mount()
    {
        $this->fecha_hora = now()->format('Y-m-d H:i');
        
        if (Auth::user()->sucursal_id) {
            $this->sucursal_id = Auth::user()->sucursal_id;
        }

        if (Auth::user()->departamento_id) {
            $this->departamento_id = Auth::user()->departamento_id;
        }
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['creator_id'] = Auth::id();
        $validatedData['status'] = 'abierto';

        Ticket::create($validatedData);

        session()->flash('message', 'Ticket creado exitosamente.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.tickets.ticket-form', [
            'sucursales' => Sucursal::where('activa', true)->get(),
            'departamentos' => Departamento::all()
        ])->layout('layouts.app');
    }
}
