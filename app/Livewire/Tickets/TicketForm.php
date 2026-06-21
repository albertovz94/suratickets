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
        $validatedData['sucursal_id'] = Auth::user()->sucursal_id;
        $validatedData['departamento_id'] = Auth::user()->departamento_id;

        // 1. Asignación Automática de Prioridad
        $textToAnalyze = strtolower($validatedData['title'] . ' ' . $validatedData['description']);
        $criticalWords = ['caído', 'caido', 'urgente', 'servidor', 'no enciende', 'internet', 'red', 'imposible', 'critico', 'crítico'];
        $highWords = ['lento', 'error', 'falla', 'pantalla azul', 'virus'];
        
        $assignedPriority = 'baja';
        foreach ($criticalWords as $word) {
            if (str_contains($textToAnalyze, $word)) {
                $assignedPriority = 'critica';
                break;
            }
        }
        if ($assignedPriority === 'baja') {
            foreach ($highWords as $word) {
                if (str_contains($textToAnalyze, $word)) {
                    $assignedPriority = 'alta';
                    break;
                }
            }
        }
        $validatedData['priority'] = $assignedPriority;

        // 2. Asignación Automática de Técnico (Menor carga de trabajo)
        // Obtenemos a los administradores
        $admins = \App\Models\User::where('rol', 'admin')->get();
        
        $assignedAdmin = null;
        if ($admins->count() > 0) {
            // Buscamos el que tenga menos tickets en estado abierto o en proceso
            $assignedAdmin = \App\Models\User::where('rol', 'admin')
                ->withCount(['assignedTickets' => function ($query) {
                    $query->whereIn('status', ['abierto', 'asignado', 'en_proceso', 'pendiente']);
                }])
                ->orderBy('assigned_tickets_count', 'asc')
                ->orderBy('id', 'asc') // Desempate por ID
                ->first();
        }

        if ($assignedAdmin) {
            $validatedData['assigned_to'] = $assignedAdmin->id;
            $validatedData['status'] = 'asignado';
        } else {
            $validatedData['status'] = 'abierto';
        }

        // 3. Crear el Ticket
        $ticket = Ticket::create($validatedData);
        \App\Models\ActivityLog::log('Crear Ticket', "Se creó el ticket #{$ticket->id}: {$ticket->title}", $ticket);

        // 4. Enviar Notificaciones a TODOS los administradores
        if ($admins->count() > 0) {
            $message = $assignedAdmin 
                ? "Nuevo ticket reportado. Asignado automáticamente a " . $assignedAdmin->name 
                : "Nuevo ticket reportado. Sin técnico asignado.";
                
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\TicketCreated($ticket, $message));
        }

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
