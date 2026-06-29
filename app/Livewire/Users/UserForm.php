<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;

use Livewire\WithFileUploads;

class UserForm extends Component
{
    use WithFileUploads;

    public $user_id;
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

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'username' => 'nullable|string|unique:users,username,' . $this->user_id,
            'role' => 'required|in:admin,usuario,outsourcing',
            'status' => 'required|in:Activo,Bloqueada,Inactivo',
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'required|exists:branches,id',
            'password' => $this->user_id ? 'nullable|min:6' : 'required|min:6',
            'avatar' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            $this->user_id = $user->id;
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

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'role' => $this->role,
            'status' => $this->status,
            'department_id' => $this->department_id,
            'branch_id' => $this->branch_id,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->avatar) {
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        if ($this->user_id) {
            User::where('id', $this->user_id)->update($data);
            $updatedUser = User::find($this->user_id);
            \App\Services\ActivityLogger::log('update_user', $updatedUser, "Actualizó la información del usuario {$updatedUser->name} ({$updatedUser->email})");

            // Optionally send email if password was changed
            if (!empty($this->password)) {
                try {
                    Mail::to($updatedUser->email)->send(new UserCredentialsMail($updatedUser, $this->password));
                } catch (\Exception $e) {
                    session()->flash('message', 'Usuario actualizado, pero hubo un error enviando el correo.');
                    return $this->redirectRoute('users.index', navigate: true);
                }
            }
            
            session()->flash('message', 'Usuario actualizado correctamente.');

        } else {
            $newUser = User::create($data);
            \App\Services\ActivityLogger::log('create_user', $newUser, "Creó el usuario {$newUser->name} ({$newUser->email}) con rol {$newUser->role}");

            if (!empty($this->password)) {
                try {
                    Mail::to($newUser->email)->send(new UserCredentialsMail($newUser, $this->password));
                } catch (\Exception $e) {
                    session()->flash('message', 'Usuario creado correctamente, pero hubo un error al enviar el correo.');
                    return $this->redirectRoute('users.index', navigate: true);
                }
            }
            
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
