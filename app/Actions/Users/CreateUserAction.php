<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use App\Services\ActivityLogger;

class CreateUserAction
{
    /**
     * Executes the creation of a new user.
     *
     * @param array $data
     * @return User
     */
    public function execute(array $data): User
    {
        $payload = [
            'name' => $data['name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'],
            'username' => $data['username'] ?? null,
            'role' => $data['role'],
            'status' => $data['status'] ?? 'Activo',
            'department_id' => $data['department_id'],
            'branch_id' => $data['branch_id'],
            'password' => Hash::make($data['password']),
        ];

        if (isset($data['avatar']) && $data['avatar']) {
            $payload['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        $user = User::create($payload);

        ActivityLogger::log('create_user', $user, "Creó el usuario {$user->name} ({$user->email}) con rol {$user->role}");

        // Envío asíncrono o síncrono del correo con accesos
        try {
            Mail::to($user->email)->send(new UserCredentialsMail($user, $data['password']));
        } catch (\Exception $e) {
            // Se propaga la excepción o se loguea para no romper la transacción si es crítico
            report($e);
        }

        return $user;
    }
}
