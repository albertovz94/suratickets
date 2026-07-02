<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use App\Services\ActivityLogger;
use App\DTOs\UserDTO;

class CreateUserAction
{
    /**
     * Executes the creation of a new user.
     *
     * @param UserDTO $dto
     * @return User
     */
    public function execute(UserDTO $dto): User
    {
        $payload = $dto->toDatabaseArray();
        $payload['password'] = Hash::make($dto->password);

        if ($dto->avatar) {
            $payload['avatar'] = $dto->avatar->store('avatars', 'public');
        }

        $user = User::create($payload);

        ActivityLogger::log('create_user', $user, "Creó el usuario {$user->name} ({$user->email}) con rol {$user->role}");

        // Envío asíncrono o síncrono del correo con accesos
        try {
            Mail::to($user->email)->send(new UserCredentialsMail($user, $dto->password));
        } catch (\Exception $e) {
            // Se propaga la excepción o se loguea para no romper la transacción si es crítico
            report($e);
        }

        return $user;
    }
}
