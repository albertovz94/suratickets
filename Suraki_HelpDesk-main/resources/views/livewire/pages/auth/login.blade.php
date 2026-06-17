<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="animate-fade-in">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-heading font-bold text-suraki-secondary">Iniciar Sesión</h2>
        <p class="text-suraki-tertiary text-sm mt-1">Ingresa tus credenciales para acceder al sistema.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Usuario')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-suraki-tertiary/50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <x-text-input wire:model="form.username" id="username" class="block w-full pl-10" type="text" name="username" required autofocus autocomplete="username" placeholder="ej. admin_sistemas" />
            </div>
            <x-input-error :messages="$errors->get('form.username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-suraki-tertiary/50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <x-text-input wire:model="form.password" id="password" class="block w-full pl-10"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-suraki-neutral-dark text-suraki-primary shadow-sm focus:ring-suraki-primary" name="remember">
                <span class="ms-2 text-sm text-suraki-tertiary">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-suraki-tertiary hover:text-suraki-primary transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-suraki-primary rounded-md" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-suraki-primary text-white font-semibold text-sm rounded-lg hover:bg-suraki-primary-hover focus:outline-none focus:ring-2 focus:ring-suraki-primary focus:ring-offset-2 transition-all duration-200 uppercase tracking-wider shadow-lg shadow-suraki-primary/25">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                {{ __('Ingresar') }}
            </button>
        </div>
    </form>
</div>
