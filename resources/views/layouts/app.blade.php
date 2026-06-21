<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestión de Tickets') }}</title>

        <!-- Fonts -->
        <link rel="icon" type="image/png" href="{{ asset('icono.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-suraki-neutral">
        <div class="flex h-screen overflow-hidden bg-suraki-neutral p-4 gap-4" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
            
            <!-- Sidebar -->
            <livewire:layout.navigation />

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                
                <!-- Topbar -->
                <div class="flex items-center justify-between bg-white p-4 rounded-2xl shadow-sm mb-4 border border-suraki-neutral-dark">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden mr-4 text-suraki-secondary focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-lg hidden md:block">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-suraki-neutral placeholder-gray-500 focus:outline-none focus:ring-suraki-primary focus:border-suraki-primary sm:text-sm transition-colors duration-200" placeholder="Buscar ticket, usuario o módulo...">
                        </div>
                    </div>
                    
                    <div class="md:hidden">
                        <img src="{{ asset('icono.png') }}" alt="Suraki Logo" class="h-8 w-auto">
                    </div>

                    <!-- Right side: Notifications & Profile -->
                    <div class="flex items-center ml-4 space-x-2 md:space-x-4">
                        <livewire:layout.notification-bell />
                        
                        <!-- Separator -->
                        <div class="hidden sm:block h-6 border-l border-suraki-neutral-dark"></div>

                        <livewire:layout.topbar-profile />
                    </div>
                </div>

                <!-- Page Content Scrollable Area -->
                <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                    <!-- Page Heading (Optional) -->
                    @if (isset($header))
                        <header class="bg-white shadow-sm rounded-2xl mb-4 p-6 hidden md:block border border-suraki-neutral-dark">
                            {{ $header }}
                        </header>
                    @endif

                    <main>
                        {{ $slot }}
                    </main>
                </div>
        </div>

        <!-- Global Toast Notification System -->
        <div x-data="{
                toasts: [],
                addToast(message) {
                    const id = Date.now();
                    this.toasts.push({ id, message });
                    setTimeout(() => this.removeToast(id), 5000);
                },
                removeToast(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }
            }"
            @show-toast.window="addToast($event.detail.message)"
            class="fixed bottom-4 right-4 z-50 flex flex-col gap-2">
            
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="true"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="transform translate-y-10 opacity-0"
                     x-transition:enter-end="transform translate-y-0 opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="transform translate-y-0 opacity-100"
                     x-transition:leave-end="transform translate-y-2 opacity-0"
                     class="bg-white border-l-4 border-suraki-primary shadow-lg rounded-r-lg p-4 max-w-sm flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-sm font-bold text-suraki-secondary mb-1">Nueva Notificación</h4>
                        <p class="text-xs text-suraki-tertiary" x-text="toast.message"></p>
                    </div>
                    <button @click="removeToast(toast.id)" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- SVG Filter for gooey effect -->
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: none;">
            <defs>
                <filter id="goo">
                    <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
                    <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
                </filter>
            </defs>
        </svg>
    </body>
</html>
