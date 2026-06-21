<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\Departamento;
use App\Models\Sucursal;
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
    public $rol = 'usuario';
    public $status = 'Activo';
    public $departamento_id = '';
    public $sucursal_id = '';
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
            'rol' => 'required|in:admin,usuario',
            'status' => 'required|in:Activo,Bloqueada,Inactivo',
            'departamento_id' => 'required|exists:departamentos,id',
            'sucursal_id' => 'required|exists:sucursales,id',
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
            $this->rol = $user->rol;
            $this->status = $user->status ?? 'Activo';
            $this->departamento_id = $user->departamento_id;
            $this->sucursal_id = $user->sucursal_id;
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
            'rol' => $this->rol,
            'status' => $this->status,
            'departamento_id' => $this->departamento_id,
            'sucursal_id' => $this->sucursal_id,
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
            \App\Models\ActivityLog::log('Actualizar Usuario', "Se actualizó el perfil del usuario {$updatedUser->username}", $updatedUser);
            
            // Optionally send email if password was changed
            if (!empty($this->password)) {
                $updatedUser = User::find($this->user_id);
                try {
                    Mail::to($updatedUser->email)->send(new UserCredentialsMail($updatedUser, $this->password));
                } catch (\Exception $e) {
                    session()->flash('message', 'Usuario actualizado, pero hubo un error enviando el correo.');
                    return redirect()->route('users.index');
                }
            }
            
            session()->flash('message', 'Usuario actualizado correctamente.');
        } else {
            $newUser = User::create($data);
            \App\Models\ActivityLog::log('Crear Usuario', "Se creó el nuevo usuario {$newUser->username}", $newUser);
            
            if (!empty($this->password)) {
                try {
                    Mail::to($newUser->email)->send(new UserCredentialsMail($newUser, $this->password));
                } catch (\Exception $e) {
                    session()->flash('message', 'Usuario creado correctamente, pero hubo un error al enviar el correo.');
                    return redirect()->route('users.index');
                }
            }
            
            session()->flash('message', 'Usuario creado correctamente y correo enviado con accesos.');
        }

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.user-form', [
            'departamentos' => Departamento::all(),
            'sucursales' => Sucursal::where('activa', true)->get(),
        ])->layout('layouts.app');
    }
}
