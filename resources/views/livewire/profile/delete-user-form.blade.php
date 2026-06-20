<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header class="flex items-center gap-2 mb-6">
        <svg class="w-6 h-6 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <h2 class="text-xl font-heading font-semibold text-suraki-secondary">
            Eliminar Cuenta
        </h2>

        <p class="mt-1 text-sm text-suraki-tertiary w-full">
            Una vez que tu cuenta sea eliminada, todos sus recursos y datos se borrarán permanentemente. Antes de eliminarla, descarga la información que desees conservar.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-all duration-200 shadow-sm shadow-red-600/20"
    >Eliminar Cuenta</button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-heading font-semibold text-suraki-secondary">
                ¿Estás seguro de que deseas eliminar tu cuenta?
            </h2>

            <p class="mt-1 text-sm text-suraki-tertiary">
                Una vez que tu cuenta sea eliminada, todos sus recursos y datos se borrarán permanentemente. Por favor, ingresa tu contraseña para confirmar la eliminación.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Contraseña" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 text-suraki-secondary"
                    placeholder="Contraseña"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center gap-2 px-4 py-2 bg-suraki-neutral text-suraki-secondary border border-suraki-neutral-dark rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all duration-200 shadow-sm">
                    Cancelar
                </button>

                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-all duration-200 shadow-sm shadow-red-600/20">
                    Eliminar Cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>
