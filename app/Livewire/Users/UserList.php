<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Support\Facades\Auth;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $departamentoFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'departamentoFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDepartamentoFilter()
    {
        $this->resetPage();
    }

    public function deleteUser($userId)
    {
        if (Auth::user()->rol !== 'admin') {
            return;
        }

        $user = User::findOrFail($userId);
        if ($user->id === Auth::id()) {
            session()->flash('error', 'No puedes eliminar tu propia cuenta.');
            return;
        }

        $user->delete();
        session()->flash('message', 'Usuario eliminado correctamente.');
    }

    public function render()
    {
        $query = User::with(['departamento'])->withCount('assignedEquipos');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->roleFilter)) {
            $query->where('rol', $this->roleFilter);
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (!empty($this->departamentoFilter)) {
            $query->where('departamento_id', $this->departamentoFilter);
        }

        $users = $query->paginate(15);

        // Stats
        $stats = [
            'total_activos' => User::where('status', 'Activo')->count(),
            'total_admins' => User::where('rol', 'admin')->count(),
            'total_bloqueadas' => User::where('status', 'Bloqueada')->count(),
            'sin_equipo' => User::doesntHave('assignedEquipos')->count(),
        ];

        return view('livewire.users.user-list', [
            'users' => $users,
            'stats' => $stats,
            'departamentos' => Departamento::all()
        ])->layout('layouts.app');
    }
}
