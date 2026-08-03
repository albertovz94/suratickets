<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $username = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $input = trim($this->username);
        $cleanInput = Str::ascii($input);

        // Buscar usuario por username o email (soportando mayúsculas, minúsculas y tildes como Liquidación vs Liquidacion)
        $user = \App\Models\User::where('username', $input)
            ->orWhere('email', $input)
            ->orWhereRaw('LOWER(username) = ?', [mb_strtolower($input)])
            ->orWhereRaw('LOWER(email) = ?', [mb_strtolower($input)])
            ->orWhereRaw('LOWER(username) = ?', [mb_strtolower($cleanInput)])
            ->first();

        if ($user) {
            if ($user->status === 'Bloqueada') {
                throw ValidationException::withMessages([
                    'form.username' => 'Tu cuenta ha sido bloqueada. Contacta a un administrador.',
                ]);
            }
            if ($user->status === 'Inactivo') {
                throw ValidationException::withMessages([
                    'form.username' => 'Tu cuenta está inactiva. Contacta a un administrador.',
                ]);
            }
        }

        // Determinar credencial a verificar (usar el email o username exacto del usuario encontrado)
        $credentials = [
            $user && $user->email === $input ? 'email' : 'username' => $user ? $user->username : $input,
            'password' => $this->password
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            // Re-intento por id de usuario si se encontró
            $authenticated = $user && Auth::loginUsingId($user->id, $this->remember) && \Illuminate\Support\Facades\Hash::check($this->password, $user->password);
            
            if (! $authenticated) {
                $attempts = RateLimiter::hit($this->throttleKey());

                if ($user && $attempts >= 5) {
                    $user->update(['status' => 'Bloqueada']);
                    throw ValidationException::withMessages([
                        'form.username' => 'Tu cuenta ha sido bloqueada por múltiples intentos fallidos.',
                    ]);
                }

                throw ValidationException::withMessages([
                    'form.username' => trans('auth.failed'),
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->username).'|'.request()->ip());
    }
}
