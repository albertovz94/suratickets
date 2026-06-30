<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use App\Models\Branch;
use App\Livewire\Forms\UserFormObject;
use App\Actions\Users\CreateUserAction;
use App\Actions\Users\UpdateUserAction;
use Livewire\WithFileUploads;

class UserForm extends Component
{
    use WithFileUploads;

    public UserFormObject $form;
    public $user_id;

    public function mount($id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            $this->user_id = $user->id;
            $this->form->setUser($user);
        }
    }

    public function save(CreateUserAction $createUser, UpdateUserAction $updateUser)
    {
        $this->form->validate();

        $data = [
            'name' => $this->form->name,
            'last_name' => $this->form->last_name,
            'email' => $this->form->email,
            'username' => $this->form->username,
            'role' => $this->form->role,
            'status' => $this->form->status,
            'department_id' => $this->form->department_id,
            'branch_id' => $this->form->branch_id,
            'password' => $this->form->password,
            'avatar' => $this->form->avatar,
        ];

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);
            $updateUser->execute($user, $data);
            session()->flash('message', 'Usuario actualizado correctamente.');
        } else {
            $createUser->execute($data);
            session()->flash('message', 'Usuario creado correctamente y correo enviado con accesos.');
        }

        return $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.users.user-form', [
            'departments' => Department::all(),
            'branches' => Branch::where('is_active', true)->get(),
        ])->layout('layouts.app');
    }
}
