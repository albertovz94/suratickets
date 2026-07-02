<?php

use App\Services\TOTP;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public bool $showingQr = false;
    public string $secret = '';
    public string $qrUrl = '';
    public string $code = '';
    public string $error = '';

    public function generate2FaSecret(): void
    {
        $this->error = '';
        $this->secret = TOTP::generateSecret();
        $this->qrUrl = TOTP::getQrUrl(Auth::user()->email, $this->secret);
        $this->showingQr = true;
    }

    public function confirm2Fa(): void
    {
        $this->error = '';

        if (TOTP::verifyCode($this->secret, $this->code)) {
            $user = Auth::user();
            $user->two_factor_secret = $this->secret;
            $user->two_factor_enabled = true;
            $user->save();

            \App\Services\ActivityLogger::log(
                'enable_2fa',
                $user,
                "El usuario {$user->name} habilitó el doble factor de autenticación (2FA)"
            );

            $this->showingQr = false;
            $this->code = '';
            $this->secret = '';
            session()->flash('status', '2fa-enabled');
        } else {
            $this->error = 'El código ingresado es incorrecto o ha expirado. Por favor, intenta de nuevo.';
        }
    }

    public function disable2Fa(): void
    {
        $user = Auth::user();
        $user->two_factor_secret = null;
        $user->two_factor_enabled = false;
        $user->save();

        \App\Services\ActivityLogger::log(
            'disable_2fa',
            $user,
            "El usuario {$user->name} deshabilitó el doble factor de autenticación (2FA)"
        );

        session()->flash('status', '2fa-disabled');
    }
}; ?>

<section>
    <header class="flex items-center gap-2 mb-6">
        <svg class="w-6 h-6 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
        </svg>
        <h2 class="text-xl font-heading font-semibold text-suraki-secondary">
            Autenticación de Doble Factor (2FA)
        </h2>
    </header>

    <div class="space-y-6">
        <p class="text-sm text-suraki-tertiary">
            Añade una capa de seguridad adicional a tu cuenta administrando la autenticación de doble factor mediante contraseñas temporales basadas en tiempo (TOTP).
        </p>

        @if (session('status') === '2fa-enabled')
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-semibold">
                La autenticación de doble factor ha sido habilitada exitosamente.
            </div>
        @elseif (session('status') === '2fa-disabled')
            <div class="p-4 bg-orange-50 border border-orange-200 text-orange-700 rounded-xl text-sm font-semibold">
                La autenticación de doble factor ha sido desactivada.
            </div>
        @endif

        @if (auth()->user()->two_factor_enabled)
            <div class="flex items-center gap-3 p-4 bg-green-50/50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/50 rounded-xl">
                <span class="w-3.5 h-3.5 rounded-full bg-green-500 animate-pulse shrink-0"></span>
                <div>
                    <p class="text-sm font-bold text-green-800 dark:text-green-400">Doble factor (2FA) activo</p>
                    <p class="text-xs text-green-700 dark:text-green-500 mt-0.5">Tu cuenta está protegida con verificación por código TOTP.</p>
                </div>
            </div>

            <div class="pt-2">
                <x-danger-button type="button" wire:click="disable2Fa" class="bg-red-600 hover:bg-red-700 transition">
                    Desactivar 2FA
                </x-danger-button>
            </div>
        @elseif ($showingQr)
            <div class="p-5 border border-suraki-neutral-dark rounded-2xl bg-gray-50 dark:bg-zinc-800/40 space-y-5">
                <h4 class="text-sm font-bold text-suraki-secondary">Configurar la aplicación autenticadora</h4>
                
                <div class="flex flex-col md:flex-row gap-6 items-center">
                    <!-- QR Code Image -->
                    <div class="bg-white p-3 border border-suraki-neutral-dark rounded-xl shadow-sm">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($qrUrl) }}" alt="QR Code" class="w-44 h-44">
                    </div>

                    <div class="space-y-3 flex-1 text-sm text-suraki-tertiary">
                        <p>1. Escanea este código QR con Google Authenticator, Microsoft Authenticator o tu app favorita.</p>
                        <p>2. Si no puedes escanear el QR, ingresa esta clave secreta manualmente:</p>
                        <code class="block p-2 bg-white dark:bg-zinc-800 border border-suraki-neutral-dark rounded-lg text-xs font-mono font-bold text-suraki-secondary tracking-wider text-center select-all">
                            {{ chunk_split($secret, 4, ' ') }}
                        </code>
                    </div>
                </div>

                <div class="pt-4 border-t border-suraki-neutral-dark space-y-4">
                    <div>
                        <x-input-label for="2fa_code" value="Ingresa el código de 6 dígitos generado por tu app" class="font-mono text-xs mb-1" />
                        <x-text-input wire:model="code" id="2fa_code" type="text" class="block w-40 text-center font-mono font-bold text-lg tracking-widest text-suraki-secondary" placeholder="000000" maxlength="6" />
                        @if ($error)
                            <p class="text-xs text-red-600 mt-2 font-semibold">{{ $error }}</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button type="button" wire:click="confirm2Fa" class="bg-suraki-primary hover:bg-suraki-primary-hover">
                            Confirmar y Habilitar
                        </x-primary-button>
                        
                        <x-secondary-button type="button" wire:click="$set('showingQr', false)">
                            Cancelar
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center gap-3 p-4 bg-orange-50/50 dark:bg-orange-950/20 border border-orange-200 dark:border-orange-900/50 rounded-xl">
                <span class="w-3.5 h-3.5 rounded-full bg-orange-500 shrink-0"></span>
                <div>
                    <p class="text-sm font-bold text-orange-800 dark:text-orange-400">Doble factor (2FA) inactivo</p>
                    <p class="text-xs text-orange-700 dark:text-orange-500 mt-0.5">Se te solicitará una clave temporal al iniciar sesión para validar tu identidad.</p>
                </div>
            </div>

            <div class="pt-2">
                <x-primary-button type="button" wire:click="generate2FaSecret" class="bg-suraki-primary hover:bg-suraki-primary-hover">
                    Habilitar 2FA
                </x-primary-button>
            </div>
        @endif
    </div>
</section>
