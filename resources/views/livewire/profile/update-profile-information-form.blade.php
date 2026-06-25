<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public ?string $last_name = '';
    public string $email = '';
    public string $username = '';
    public ?string $phone = '';
    public ?string $bio = '';
    public string $display_preference = 'name';
    public ?int $department_id = null;
    public $photo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->last_name = Auth::user()->last_name;
        $this->email = Auth::user()->email;
        $this->username = Auth::user()->username;
        $this->phone = Auth::user()->phone;
        $this->bio = Auth::user()->bio;
        $this->display_preference = Auth::user()->display_preference ?? 'name';
        $this->department_id = Auth::user()->department_id;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'display_preference' => ['required', 'string', Rule::in(['name', 'full_name', 'username'])],
            'department_id' => ['nullable', 'exists:departments,id'],
            'photo' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ]);

        $user->fill([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone' => $validated['phone'],
            'bio' => $validated['bio'],
            'display_preference' => $validated['display_preference'],
            'department_id' => $validated['department_id'],
        ]);

        if ($this->photo) {
            $path = $this->photo->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        $user->notify(new \App\Notifications\ProfileUpdatedNotification('Tu perfil general y/o foto fueron actualizados con éxito.'));

        $this->dispatch('profile-updated', name: $user->name);
        
        // Refresh the page fully to make sure topbar is updated
        $this->redirect(request()->header('Referer'), navigate: true);
    }

    public function useDepartmentIcon(): void
    {
        $user = Auth::user();
        if ($this->department_id) {
            $depName = \App\Models\Department::find($this->department_id)->name ?? 'User';
            // Utilizamos DiceBear para generar un avatar 3D-ish basado en el departamento
            $user->avatar = 'https://api.dicebear.com/9.x/micah/svg?seed=' . urlencode($depName) . '&backgroundColor=f1f5f9';
            $user->save();
            $user->notify(new \App\Notifications\ProfileUpdatedNotification('Tu ícono 3D de departamento se ha aplicado.'));
            $this->dispatch('profile-updated', name: $user->name);
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="flex items-center gap-2 mb-6">
        <svg class="w-6 h-6 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
        </svg>
        <h2 class="text-xl font-heading font-semibold text-suraki-secondary">
            Información Personal
        </h2>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-6">
        
        <!-- Foto de Perfil / Avatar -->
        <div class="flex items-center gap-6">
            <div class="shrink-0 w-24 h-24 rounded-full overflow-hidden border border-suraki-neutral-dark bg-suraki-neutral flex items-center justify-center text-3xl font-bold text-suraki-primary shadow-sm bg-white">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                @elseif (auth()->user()->avatar_path)
                    <img src="{{ auth()->user()->avatar_path }}" class="w-full h-full object-cover" alt="Avatar">
                @else
                    {{ substr(auth()->user()->name, 0, 1) }}
                @endif
            </div>
            
            <div class="space-y-3">
                <div>
                    <x-input-label for="photo" value="Subir foto personalizada" class="font-mono text-sm" />
                    <input type="file" wire:model="photo" id="photo" class="mt-1 block w-full text-sm text-suraki-secondary file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-suraki-primary-light file:text-suraki-primary hover:file:bg-suraki-primary hover:file:text-white transition-colors cursor-pointer border border-suraki-neutral-dark rounded-md">
                    <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                </div>
                
                @if($department_id)
                    <button type="button" wire:click="useDepartmentIcon" class="text-sm font-medium text-suraki-primary hover:text-suraki-primary-hover transition-colors underline decoration-dotted underline-offset-4">
                        O usar ícono 3D de {{ \App\Models\Department::find($department_id)->name ?? 'tu departamento' }}
                    </button>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
            <!-- Col 1 -->
            <div>
                <x-input-label for="name" value="Nombre" class="font-mono text-sm text-suraki-secondary" />
                <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full text-suraki-secondary" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Col 2 -->
            <div>
                <x-input-label for="last_name" value="Apellido" class="font-mono text-sm text-suraki-secondary" />
                <x-text-input wire:model="last_name" id="last_name" name="last_name" type="text" class="mt-1 block w-full text-suraki-secondary" autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>

            <!-- Col 1 -->
            <div>
                <x-input-label for="email" value="Correo Electrónico" class="font-mono text-sm text-suraki-secondary" />
                <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full text-suraki-secondary" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-suraki-secondary">
                            {{ __('Your email address is unverified.') }}

                            <button wire:click.prevent="sendVerification" class="underline text-sm text-suraki-tertiary hover:text-suraki-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-suraki-primary">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Col 2 -->
            <div>
                <x-input-label for="phone" value="Teléfono" class="font-mono text-sm text-suraki-secondary" />
                <x-text-input wire:model="phone" id="phone" name="phone" type="text" class="mt-1 block w-full text-suraki-secondary" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- Col 1 -->
            <div>
                <x-input-label for="username" value="Usuario" class="font-mono text-sm text-suraki-secondary" />
                <x-text-input wire:model="username" id="username" name="username" type="text" class="mt-1 block w-full text-suraki-secondary" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <!-- Col 2 -->
            <div>
                <x-input-label for="display_preference" value="Mostrar nombre como" class="font-mono text-sm text-suraki-secondary" />
                <select wire:model="display_preference" id="display_preference" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-suraki-primary focus:ring-suraki-primary text-suraki-secondary">
                    <option value="name">Solo Nombre</option>
                    <option value="full_name">Nombre y Apellido</option>
                    <option value="username">Usuario</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('display_preference')" />
            </div>

            <!-- Full Width -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label for="department_id" value="Departamento" class="font-mono text-sm text-suraki-secondary" />
                <select wire:model.live="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-suraki-primary focus:ring-suraki-primary text-suraki-secondary">
                    <option value="">-- Seleccionar --</option>
                    @foreach(\App\Models\Department::all() as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
            </div>

            <!-- Full Width -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label for="bio" value="Biografía Profesional" class="font-mono text-sm text-suraki-secondary" />
                <textarea wire:model="bio" id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-suraki-primary focus:ring-suraki-primary text-suraki-secondary resize-y" placeholder="Escribe un breve resumen de tu experiencia y rol..."></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            </div>

        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-suraki-neutral-dark">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-suraki-primary text-white rounded-lg text-sm font-semibold hover:bg-suraki-primary-hover transition-all duration-200 shadow-sm shadow-suraki-primary/20">
                Guardar
            </button>

            <x-action-message class="me-3 text-green-600 font-medium" on="profile-updated">
                Guardado exitosamente.
            </x-action-message>
        </div>
    </form>
</section>
