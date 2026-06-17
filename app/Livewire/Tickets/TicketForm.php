<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TicketStatusUpdatedNotification;

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

        // Auto-asignación inteligente
        $bestAdmin = User::where('rol', 'admin')
            ->withCount(['assignedTickets' => function ($query) {
                $query->whereIn('status', ['abierto', 'en_proceso']);
            }])
            ->orderBy('assigned_tickets_count', 'asc')
            ->first();

        if ($bestAdmin) {
            $validatedData['assigned_to'] = $bestAdmin->id;
        }

        $ticket = Ticket::create($validatedData);

        if ($bestAdmin) {
            $bestAdmin->notify(new TicketStatusUpdatedNotification($ticket, "Se te ha asignado un nuevo ticket: " . $ticket->title));
        }

        session()->flash('message', 'Ticket creado exitosamente.');
        $this->reset(['title', 'description', 'area_departamento', 'equipo_afectado', 'priority']);
        $this->dispatch('close-ticket-modal');
    }

    public function render()
    {
        return view('livewire.tickets.ticket-form', [
            'sucursales' => Sucursal::all()
        ]);
    }
}
