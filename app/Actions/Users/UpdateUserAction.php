<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use App\Services\ActivityLogger;

class UpdateUserAction
{
    /**
     * Executes the update of an existing user.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function execute(User $user, array $data): User
    {
        $payload = [
            'name' => $data['name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'],
            'username' => $data['username'] ?? null,
            'role' => $data['role'],
            'status' => $data['status'],
            'department_id' => $data['department_id'],
            'branch_id' => $data['branch_id'],
        ];

        if (isset($data['password']) && !empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        if (isset($data['avatar']) && $data['avatar']) {
            $payload['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        $user->update($payload);

        ActivityLogger::log('update_user', $user, "Actualizó la información del usuario {$user->name} ({$user->email})");

        // Enviar correo de credenciales si la contraseña fue cambiada
        if (isset($data['password']) && !empty($data['password'])) {
            try {
                Mail::to($user->email)->send(new UserCredentialsMail($user, $data['password']));
            } catch (\Exception $e) {
                report($e);
            }
        }

        return $user;
    }
}
