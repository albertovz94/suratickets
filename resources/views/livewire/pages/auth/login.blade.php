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

        $user = Auth::user();
        if ($user->two_factor_enabled) {
            Session::put('2fa:user_id', $user->id);
            Session::put('2fa:remember', $this->form->remember);
            
            Auth::logout();
            
            $this->redirect(route('login.2fa'), navigate: true);
            return;
        }

        if ($user->hasAdminAccess()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('tickets.index', absolute: false), navigate: true);
        }
    }
}; ?>

<div class="animate-fade-in w-full max-w-sm mx-auto">
    <!-- Header with Icon -->
    <div class="flex flex-col items-center mb-8">
        <div class="relative flex items-center justify-center w-24 h-24 mb-4 rounded-full shadow-[0_0_20px_rgba(0,0,0,0.1)] border-4 border-gray-100 bg-white overflow-hidden p-3 animate-float-glow">
            <!-- Icon Image -->
            <img src="{{ asset('icono.png') }}" alt="Icono Login" class="w-full h-full object-contain filter drop-shadow-md">
        </div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Iniciar Sesión</h2>
        <p class="text-gray-500 text-sm mt-1">Accede a tu cuenta</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" x-on:submit="window.useLoading().show('Iniciando sesión...', 6000)" class="space-y-4">
        <!-- Username -->
        <div>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-indigo-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model="form.username" id="username" class="block w-full pl-12 pr-4 py-3 border border-orange-200 rounded-xl focus:ring-suraki-primary focus:border-suraki-primary bg-gray-50/50 text-gray-900 transition-colors" type="text" name="username" required autofocus autocomplete="username" placeholder="Usuario" />
            </div>
            <x-input-error :messages="$errors->get('form.username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="relative mt-1" x-data="{ showPass: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model="form.password" id="password" class="block w-full pl-12 pr-12 py-3 border border-orange-200 rounded-xl focus:ring-suraki-primary focus:border-suraki-primary bg-gray-50/50 text-gray-900 transition-colors"
                                :type="showPass ? 'text' : 'password'"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="Contraseña" />
                <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" tabindex="-1" title="Mostrar / Ocultar contraseña">
                    <svg x-show="!showPass" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPass" class="h-5 w-5 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.03 10.03 0 012.122-.363c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21f-9-9M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-suraki-primary" name="remember">
                <span class="ms-2 text-sm text-gray-500">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-suraki-primary hover:text-red-500 transition-colors duration-150" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-4 pb-4">
            <button type="submit" class="blob-btn">
                <span style="position:relative; z-index: 10;">{{ __('INGRESAR') }}</span>
                <span class="blob-btn__inner">
                    <span class="blob-btn__blobs">
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                    </span>
                </span>
            </button>
        </div>

    </form>
</div>
