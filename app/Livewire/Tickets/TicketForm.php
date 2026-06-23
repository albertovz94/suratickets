<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Sucursal;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Actions\Tickets\CreateTicketAction;

class TicketForm extends Component
{
    public $title = '';
    public $description = '';
    public $sucursal_id = '';
    public $departamento_id = '';
    public $priority = 'baja';
    public $fecha_hora = '';
    public $categoria = '';
    public $is_it_available = true;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:2000',
        'priority' => 'required|in:baja,media,alta,critica',
        'categoria' => 'required|in:hardware,software,redes,otros',
    ];

    public function mount()
    {
        $this->checkItAvailability();
        $this->fecha_hora = now()->format('Y-m-d H:i');
        
        if (Auth::user()->sucursal_id) {
            $this->sucursal_id = Auth::user()->sucursal_id;
        }

        if (Auth::user()->departamento_id) {
            $this->departamento_id = Auth::user()->departamento_id;
        }
    }

    public function checkItAvailability()
    {
        $admins = User::admins()->get();
        
        $workingAdmins = $admins->filter(function($admin) {
            return $admin->isWorkingNow();
        });

        $this->is_it_available = $workingAdmins->count() > 0;
    }

    public function save(CreateTicketAction $action)
    {
        $validatedData = $this->validate();
        $validatedData['creator_id'] = Auth::id();
        $validatedData['sucursal_id'] = Auth::user()->sucursal_id;
        $validatedData['departamento_id'] = Auth::user()->departamento_id;

        $action->execute($validatedData);

        session()->flash('message', 'Ticket creado y asignado exitosamente.');
        return redirect()->route('tickets.index');
    }

    public function render()
    {
        return view('livewire.tickets.ticket-form', [
            'sucursales' => Sucursal::where('activa', true)->get(),
            'departamentos' => Departamento::all()
        ])->layout('layouts.app');
    }
}
