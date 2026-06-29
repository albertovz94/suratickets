<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ticket;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Actions\Tickets\CreateTicketAction;

class TicketForm extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $branch_id = '';
    public $department_id = '';
    public $priority = 'baja';
    public $date_time = '';
    public $category = '';
    public $attachment;
    public $is_it_available = true;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:2000',
        'priority' => 'required|in:baja,media,alta,critica',
        'category' => 'required|in:hardware,software,redes,otros',
        'attachment' => 'nullable|file|max:10240',
    ];

    public function mount()
    {
        $this->checkItAvailability();
        $this->date_time = now()->format('Y-m-d H:i');
        
        if (Auth::user()->branch_id) {
            $this->branch_id = Auth::user()->branch_id;
        }

        if (Auth::user()->department_id) {
            $this->department_id = Auth::user()->department_id;
        }
    }

    public function checkItAvailability()
    {
        $admins = User::assignableAdmins()->get();
        
        $workingAdmins = $admins->filter(function($admin) {
            return $admin->isWorkingNow();
        });

        $this->is_it_available = $workingAdmins->count() > 0;
    }

    public function save(CreateTicketAction $action)
    {
        $validatedData = $this->validate();
        $validatedData['creator_id'] = Auth::id();
        $validatedData['branch_id'] = Auth::user()->branch_id;
        $validatedData['department_id'] = Auth::user()->department_id;

        if ($this->attachment) {
            $validatedData['attachment_path'] = $this->attachment->store('attachments', 'public');
        }

        $action->execute($validatedData);

        session()->flash('message', 'Ticket creado y asignado exitosamente.');
        return redirect()->route('tickets.index');
    }

    public function render()
    {
        $dropdowns = \Illuminate\Support\Facades\Cache::remember('ticket_form_dropdowns', 3600, function() {
            return [
                'branches' => Branch::where('is_active', true)->get(),
                'departments' => Department::all()
            ];
        });

        return view('livewire.tickets.ticket-form', [
            'branches' => $dropdowns['branches'],
            'departments' => $dropdowns['departments']
        ])->layout('layouts.app');
    }
}
