<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};
?>

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <!-- Trigger -->
    <button @click="open = !open" class="flex items-center gap-3 focus:outline-none hover:bg-suraki-neutral p-1.5 rounded-xl transition-colors duration-200">
        <div class="w-10 h-10 shrink-0 rounded-full border-2 border-transparent hover:border-suraki-primary transition-colors bg-suraki-neutral flex items-center justify-center text-suraki-primary font-bold shadow-sm overflow-hidden bg-white">
            @if(auth()->user()->avatar_path)
                <img src="{{ auth()->user()->avatar_path }}" class="w-full h-full object-cover" alt="Avatar">
            @else
                {{ substr(auth()->user()->name, 0, 1) }}
            @endif
        </div>
        <div class="text-left hidden md:block">
            <p class="text-sm font-bold text-suraki-secondary leading-none">{{ auth()->user()->display_name }}</p>
            <p class="text-xs text-suraki-tertiary mt-1 font-mono lowercase">{{ auth()->user()->rol }}</p>
        </div>
        <svg class="w-4 h-4 text-suraki-tertiary ml-1 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    <!-- Dropdown -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
         class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border border-suraki-neutral-dark z-50 overflow-hidden"
         style="display: none;">
        
        <div class="py-2">
            <div class="px-4 py-3 md:hidden">
                <span class="text-sm font-semibold text-suraki-secondary">{{ auth()->user()->display_name }}</span>
                <p class="text-xs text-suraki-tertiary font-mono truncate">{{ auth()->user()->email }}</p>
            </div>
            
            <div class="h-px bg-suraki-neutral-dark my-1 md:hidden"></div>

            <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-suraki-secondary hover:bg-suraki-neutral hover:text-suraki-primary transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Ver perfil
            </a>
            
            <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-suraki-secondary hover:bg-suraki-neutral hover:text-suraki-primary transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                </svg>
                Cambiar foto
            </a>
            
            @if(auth()->user()->rol === 'admin')
            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-suraki-secondary hover:bg-suraki-neutral hover:text-suraki-primary transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Configuración
            </a>
            @endif
            
            <div class="h-px bg-suraki-neutral-dark my-1"></div>
            
            <button wire:click="logout" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                Cerrar sesión
            </button>
        </div>
    </div>
</div>
