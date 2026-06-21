<?php

use App\Models\User;
use App\Notifications\PasswordResetAdminNotification;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $username = '';

    /**
     * Notify admins about password reset request.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'username' => ['required', 'string', 'exists:users,username'],
        ], [
            'username.exists' => 'Este nombre de usuario no existe en el sistema.',
        ]);

        $user = User::where('username', $this->username)->first();
        $admins = User::where('rol', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new PasswordResetAdminNotification($user));
        }

        $this->reset('username');

        session()->flash('status', 'Los administradores han sido notificados. Revisa tu correo electrónico más tarde para obtener tus nuevas credenciales.');
    }
}; ?>

<div class="animate-fade-in w-full max-w-sm mx-auto">
    <!-- Header with Icon -->
    <div class="flex flex-col items-center mb-8">
        <div class="relative flex items-center justify-center w-24 h-24 mb-4 rounded-full shadow-[0_0_20px_rgba(0,0,0,0.1)] border-4 border-gray-100 bg-white overflow-hidden p-3 animate-float-glow">
            <!-- Icon Image -->
            <img src="{{ asset('icono.png') }}" alt="Icono Recuperación" class="w-full h-full object-contain filter drop-shadow-md">
        </div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Recuperar Contraseña</h2>
        <p class="text-gray-500 text-sm mt-1 text-center">Ingresa tu usuario y avisaremos a sistemas</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-green-600 font-bold bg-green-50 p-4 rounded-xl border border-green-200" :status="session('status')" />

    @if(!session('status'))
    <form wire:submit="sendPasswordResetLink" class="space-y-4">
        <!-- Username -->
        <div>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-indigo-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model="username" id="username" class="block w-full pl-12 pr-4 py-3 border border-orange-200 rounded-xl focus:ring-[#ff5a5f] focus:border-[#ff5a5f] bg-gray-50/50 text-gray-900 transition-colors" type="text" name="username" required autofocus placeholder="Tu Usuario" />
            </div>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors duration-150" href="{{ route('login') }}" wire:navigate>
                {{ __('Volver al Login') }}
            </a>
        </div>

        <!-- Submit Button -->
        <div class="pt-4 pb-4">
            <button type="submit" class="blob-btn">
                <span style="position:relative; z-index: 10;">SOLICITAR ACCESO</span>
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
    @else
        <div class="pt-4 pb-4 text-center">
            <a href="{{ route('login') }}" class="inline-block text-[#ff5a5f] font-bold hover:underline" wire:navigate>Volver al inicio</a>
        </div>
    @endif
</div>
