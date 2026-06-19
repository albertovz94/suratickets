<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="flex items-center gap-2 mb-6">
        <svg class="w-6 h-6 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
        </svg>
        <h2 class="text-xl font-heading font-semibold text-suraki-secondary">
            Actualizar Contraseña
        </h2>

        <p class="mt-1 text-sm text-suraki-tertiary w-full">
            Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerse segura.
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="update_password_current_password" value="Contraseña Actual" class="font-mono text-sm text-suraki-secondary" />
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full text-suraki-secondary" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nueva Contraseña" class="font-mono text-sm text-suraki-secondary" />
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full text-suraki-secondary" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar Contraseña" class="font-mono text-sm text-suraki-secondary" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full text-suraki-secondary" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-suraki-neutral-dark">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-suraki-primary text-white rounded-lg text-sm font-semibold hover:bg-suraki-primary-hover transition-all duration-200 shadow-sm shadow-suraki-primary/20">
                Guardar
            </button>

            <x-action-message class="me-3 text-green-600 font-medium" on="password-updated">
                Guardado exitosamente.
            </x-action-message>
        </div>
    </form>
</section>
