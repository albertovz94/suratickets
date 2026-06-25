<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $departmentFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'departmentFilter' => ['except' => ''],
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

    public function updatingDepartmentFilter()
    {
        $this->resetPage();
    }

    public function deleteUser($userId)
    {
        if (!Auth::user()->hasAdminAccess()) {
            return;
        }

        $user = User::findOrFail($userId);
        if ($user->id === Auth::id()) {
            session()->flash('error', 'No puedes eliminar tu propia cuenta.');
            return;
        }

        $user->delete();
        $this->dispatch('notify', message: 'Usuario eliminado correctamente.'); session()->flash('message', 'Usuario eliminado correctamente.');
    }

    public function toggleUserStatus($userId)
    {
        if (!Auth::user()->hasAdminAccess()) {
            return;
        }

        $user = User::findOrFail($userId);
        if ($user->id === Auth::id()) {
            $this->dispatch('show-toast', message: 'No puedes cambiar el estado de tu propia cuenta.');
            return;
        }

        if ($user->status === 'Activo') {
            $user->status = 'Inactivo';
            $this->dispatch('show-toast', message: "El usuario {$user->name} ha sido deshabilitado.");
        } else {
            $user->status = 'Activo';
            $this->dispatch('show-toast', message: "El usuario {$user->name} ha sido habilitado.");
        }

        $user->save();
    }

    public function render()
    {
        $query = User::with(['department'])->withCount('assignedDevices');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->roleFilter)) {
            $query->where('role', $this->roleFilter);
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (!empty($this->departmentFilter)) {
            $query->where('department_id', $this->departmentFilter);
        }

        $users = $query->paginate(15);

        // Stats
        $stats = [
            'total_activos' => User::where('status', 'Activo')->count(),
            'total_admins' => User::whereIn('role', ['admin', 'outsourcing'])->count(),
            'total_bloqueadas' => User::where('status', 'Bloqueada')->count(),
            'sin_equipo' => User::doesntHave('assignedDevices')->count(),
        ];

        return view('livewire.users.user-list', [
            'users' => $users,
            'stats' => $stats,
            'departments' => Department::all()
        ])->layout('layouts.app');
    }
}
