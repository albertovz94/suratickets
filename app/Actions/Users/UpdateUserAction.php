<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use App\Services\ActivityLogger;
use App\DTOs\UserDTO;

class UpdateUserAction
{
    /**
     * Executes the update of an existing user.
     *
     * @param User $user
     * @param UserDTO $dto
     * @return User
     */
    public function execute(User $user, UserDTO $dto): User
    {
        $payload = $dto->toDatabaseArray();

        if ($dto->password) {
            $payload['password'] = Hash::make($dto->password);
        }

        if ($dto->avatar) {
            $payload['avatar'] = $dto->avatar->store('avatars', 'public');
        }

        $user->update($payload);

        ActivityLogger::log('update_user', $user, "Actualizó la información del usuario {$user->name} ({$user->email})");

        // Enviar correo de credenciales si la contraseña fue cambiada
        if ($dto->password) {
            try {
                Mail::to($user->email)->send(new UserCredentialsMail($user, $dto->password));
            } catch (\Exception $e) {
                report($e);
            }
        }

        return $user;
    }
}
