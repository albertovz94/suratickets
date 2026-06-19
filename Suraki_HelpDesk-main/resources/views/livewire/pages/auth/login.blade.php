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

<div class="animate-fade-in w-full max-w-sm mx-auto">
    <!-- Header with Icon -->
    <div class="flex flex-col items-center mb-8">
        <div class="relative flex items-center justify-center w-24 h-24 mb-4 rounded-full shadow-[0_0_20px_rgba(228,63,69,0.4)] border-4 border-white/50 backdrop-blur-sm overflow-hidden p-3 animate-float-glow" style="background-color: #e43f45;">
            <!-- Icon Image -->
            <img src="{{ asset('icono.png') }}" alt="Icono Login" class="w-full h-full object-contain filter drop-shadow-md">
        </div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Iniciar Sesión</h2>
        <p class="text-gray-500 text-sm mt-1">Accede a tu cuenta</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <!-- Username -->
        <div>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-indigo-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model="form.username" id="username" class="block w-full pl-12 pr-4 py-3 border border-orange-200 rounded-xl focus:ring-[#ff5a5f] focus:border-[#ff5a5f] bg-gray-50/50 text-gray-900 transition-colors" type="text" name="username" required autofocus autocomplete="username" placeholder="Usuario" />
            </div>
            <x-input-error :messages="$errors->get('form.username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model="form.password" id="password" class="block w-full pl-12 pr-4 py-3 border border-orange-200 rounded-xl focus:ring-[#ff5a5f] focus:border-[#ff5a5f] bg-gray-50/50 text-gray-900 transition-colors"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="Contraseña" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-[#ff5a5f]" name="remember">
                <span class="ms-2 text-sm text-gray-500">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#ff5a5f] hover:text-red-500 transition-colors duration-150" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center items-center px-4 py-3.5 text-white font-bold text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 uppercase tracking-widest shadow-[0_4px_14px_0_rgba(208,55,61,0.39)] hover:shadow-[0_6px_20px_rgba(208,55,61,0.23)] hover:-translate-y-0.5" style="background-color: #d0373d;" onmouseover="this.style.backgroundColor='#b92c31'" onmouseout="this.style.backgroundColor='#d0373d'">
                {{ __('INGRESAR') }}
            </button>
        </div>
    </form>
</div>
