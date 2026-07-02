<?php

use App\Services\TOTP;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $code = '';
    public string $error = '';

    public function mount(): void
    {
        if (!Session::has('2fa:user_id')) {
            $this->redirect(route('login'), navigate: true);
        }
    }

    public function verify(): void
    {
        $this->error = '';

        if (!Session::has('2fa:user_id')) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        $userId = Session::get('2fa:user_id');
        $remember = Session::get('2fa:remember', false);

        $user = User::findOrFail($userId);

        if (TOTP::verifyCode($user->two_factor_secret, $this->code)) {
            Auth::loginUsingId($user->id, $remember);
            
            Session::forget(['2fa:user_id', '2fa:remember']);
            Session::regenerate();

            \App\Services\ActivityLogger::log(
                'login_2fa_success',
                $user,
                "El usuario {$user->name} inició sesión exitosamente usando doble factor (2FA)"
            );

            if ($user->hasAdminAccess()) {
                $this->redirect(route('dashboard'), navigate: true);
            } else {
                $this->redirect(route('tickets.index'), navigate: true);
            }
        } else {
            $this->error = 'El código ingresado es incorrecto o ha expirado. Por favor, verifica el código en tu app.';
        }
    }
}; ?>

<div class="animate-fade-in w-full max-w-sm mx-auto">
    <!-- Header with Icon -->
    <div class="flex flex-col items-center mb-8">
        <div class="relative flex items-center justify-center w-24 h-24 mb-4 rounded-full shadow-[0_0_20px_rgba(0,0,0,0.1)] border-4 border-gray-100 bg-white overflow-hidden p-3 animate-float-glow">
            <svg class="w-12 h-12 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Verificación 2FA</h2>
        <p class="text-gray-500 text-sm mt-1 text-center">Ingresa el código de 6 dígitos de tu aplicación autenticadora para acceder.</p>
    </div>

    <form wire:submit="verify" class="space-y-6">
        <div>
            <div class="relative mt-1 flex justify-center">
                <input wire:model="code" 
                       id="code" 
                       class="block w-48 text-center font-mono font-bold text-2xl tracking-[0.4em] py-3 border border-orange-200 rounded-xl focus:ring-suraki-primary focus:border-suraki-primary bg-gray-50/50 text-gray-900 transition-colors" 
                       type="text" 
                       required 
                       autofocus 
                       autocomplete="one-time-code" 
                       placeholder="000000" 
                       maxlength="6"
                />
            </div>
            
            @if ($error)
                <p class="text-xs text-red-600 mt-3 text-center font-semibold">{{ $error }}</p>
            @endif
        </div>

        <div class="flex flex-col gap-3">
            <x-primary-button type="submit" class="w-full justify-center bg-suraki-primary hover:bg-suraki-primary-hover">
                Verificar Código
            </x-primary-button>
            
            <a href="{{ route('login') }}" wire:navigate class="text-center text-sm font-medium text-suraki-tertiary hover:text-suraki-secondary transition-colors underline decoration-dotted underline-offset-4">
                Volver al login
            </a>
        </div>
    </form>
</div>
