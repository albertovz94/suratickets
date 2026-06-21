<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <!-- Sidebar overlay (mobile) -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-black/50 md:hidden" @click="sidebarOpen = false" style="display: none;"></div>

    <!-- Sidebar Container -->
    <aside :class="{
            'translate-x-0': sidebarOpen, 
            '-translate-x-full': !sidebarOpen,
            'w-[280px] min-w-[280px]': !sidebarCollapsed,
            'w-[88px] min-w-[88px]': sidebarCollapsed
        }" 
        class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white rounded-2xl p-4 transition-all duration-300 md:static md:translate-x-0 h-full shadow-sm border border-suraki-neutral-dark overflow-hidden">
        
        <!-- Header / Logo -->
        <div class="flex items-center justify-between mb-8 px-2 mt-2">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 overflow-hidden">
                <img src="{{ asset('icono.png') }}" alt="Suraki" class="w-8 h-8 object-contain shrink-0">
                <span x-show="!sidebarCollapsed" class="font-heading font-bold text-xl text-suraki-secondary transition-opacity duration-300">Gestión de Tickets</span>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-suraki-tertiary">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Modules -->
        <nav class="flex-1 space-y-2">
            @if(auth()->user()->rol === 'admin')
            <a href="{{ route('dashboard') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-suraki-primary text-white shadow-sm shadow-suraki-primary/30' : 'text-suraki-tertiary hover:bg-suraki-neutral hover:text-suraki-secondary' }}"
               :title="sidebarCollapsed ? 'Panel Principal' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Panel Principal</span>
            </a>
            @endif

            <a href="{{ route('tickets.index') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-colors duration-200 {{ request()->routeIs('tickets.*') ? 'bg-suraki-primary text-white shadow-sm shadow-suraki-primary/30' : 'text-suraki-tertiary hover:bg-suraki-neutral hover:text-suraki-secondary' }}"
               :title="sidebarCollapsed ? 'Tickets' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Tickets</span>
            </a>

            @if(auth()->user()->rol === 'admin')
            <a href="{{ route('inventory.index') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-colors duration-200 {{ request()->routeIs('inventory.*') ? 'bg-suraki-primary text-white shadow-sm shadow-suraki-primary/30' : 'text-suraki-tertiary hover:bg-suraki-neutral hover:text-suraki-secondary' }}"
               :title="sidebarCollapsed ? 'Inventario' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Inventario</span>
            </a>
            @endif

            @if(auth()->user()->rol === 'admin')
            <a href="{{ route('users.index') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-colors duration-200 {{ request()->routeIs('users.*') ? 'bg-suraki-primary text-white shadow-sm shadow-suraki-primary/30' : 'text-suraki-tertiary hover:bg-suraki-neutral hover:text-suraki-secondary' }}"
               :title="sidebarCollapsed ? 'Usuarios' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Usuarios</span>
            </a>

            <a href="{{ route('reports.index') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-colors duration-200 {{ request()->routeIs('reports.*') ? 'bg-suraki-primary text-white shadow-sm shadow-suraki-primary/30' : 'text-suraki-tertiary hover:bg-suraki-neutral hover:text-suraki-secondary' }}"
               :title="sidebarCollapsed ? 'Reportes' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Reportes</span>
            </a>

            <a href="{{ route('bitacora.index') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-colors duration-200 {{ request()->routeIs('bitacora.*') ? 'bg-suraki-primary text-white shadow-sm shadow-suraki-primary/30' : 'text-suraki-tertiary hover:bg-suraki-neutral hover:text-suraki-secondary' }}"
               :title="sidebarCollapsed ? 'Bitácora' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Bitácora</span>
            </a>

            <a href="{{ route('settings.index') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold transition-colors duration-200 {{ request()->routeIs('settings.*') ? 'bg-suraki-primary text-white shadow-sm shadow-suraki-primary/30' : 'text-suraki-tertiary hover:bg-suraki-neutral hover:text-suraki-secondary' }}"
               :title="sidebarCollapsed ? 'Configuración' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Configuración</span>
            </a>
            @endif

        </nav>

        <!-- Sidebar Collapse Toggle Button -->
        <div class="mb-4 hidden md:flex items-center justify-center">
            <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-2 rounded-full bg-suraki-neutral text-suraki-tertiary hover:text-suraki-secondary hover:bg-gray-200 transition-colors shadow-sm border border-suraki-neutral-dark" title="Expandir/Contraer Menú">
                <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                </svg>
                <svg x-show="sidebarCollapsed" class="w-5 h-5 hidden" :class="{'hidden': !sidebarCollapsed}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>

        <!-- Footer / User Actions -->
        <div class="mt-auto pt-6 border-t border-suraki-neutral-dark">
            <button wire:click="logout" class="flex w-full items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors duration-200" :class="{'justify-center': sidebarCollapsed}" :title="sidebarCollapsed ? 'Cerrar Sesión' : ''">
                <div class="w-6 h-6 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Cerrar Sesión</span>
            </button>
        </div>
    </aside>
</div>
