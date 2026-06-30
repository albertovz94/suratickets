<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;

class UserFormObject extends Form
{
    public ?User $user = null;

    public $name = '';
    public $last_name = '';
    public $email = '';
    public $username = '';
    public $role = 'usuario';
    public $status = 'Activo';
    public $department_id = '';
    public $branch_id = '';
    public $password = '';
    public $avatar;
    public $existing_avatar;

    public function rules()
    {
        $userId = $this->user ? $this->user->id : null;

        return [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'username' => 'nullable|string|unique:users,username,' . $userId,
            'role' => 'required|in:admin,usuario,outsourcing',
            'status' => 'required|in:Activo,Bloqueada,Inactivo',
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'required|exists:branches,id',
            'password' => $userId ? 'nullable|min:6' : 'required|min:6',
            'avatar' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    /**
     * Load user data into the form object.
     *
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->role = $user->role;
        $this->status = $user->status ?? 'Activo';
        $this->department_id = $user->department_id;
        $this->branch_id = $user->branch_id;
        $this->existing_avatar = $user->avatar_path;
    }
}
