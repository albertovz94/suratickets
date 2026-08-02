<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="light"
      x-data="{ 
          shortcutsModalOpen: false
      }"
      x-on:keydown.window="
          if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName) || document.activeElement.isContentEditable) return;
          
          if ($event.key === '?') {
              shortcutsModalOpen = !shortcutsModalOpen;
          } else if ($event.key === 'Escape') {
              shortcutsModalOpen = false;
          } else if ($event.key === '/') {
              $event.preventDefault();
              document.getElementById('topbar-search')?.focus();
          } else if ($event.key.toLowerCase() === 'g') {
              window.gPressed = true;
              setTimeout(() => window.gPressed = false, 1000);
          } else if (window.gPressed) {
              const key = $event.key.toLowerCase();
              window.gPressed = false;
              if (key === 'd') Livewire.navigate('{{ route('dashboard') }}');
              if (key === 't') Livewire.navigate('{{ route('tickets.index') }}');
              if (key === 'r') Livewire.navigate('{{ route('requests.index') }}');
              if (key === 'h') Livewire.navigate('{{ route('schedules.index') }}');
              if (key === 'i') Livewire.navigate('{{ route('inventory.index') }}');
              if (key === 'u') Livewire.navigate('{{ route('users.index') }}');
              if (key === 'p') Livewire.navigate('{{ route('reports.index') }}');
              if (key === 's') Livewire.navigate('{{ route('settings.index') }}');
          } else if ($event.key.toLowerCase() === 'c') {
              window.cPressed = true;
              setTimeout(() => window.cPressed = false, 1000);
          } else if (window.cPressed) {
              const key = $event.key.toLowerCase();
              window.cPressed = false;
              if (key === 't') Livewire.navigate('{{ route('tickets.create') }}');
              if (key === 'r') Livewire.navigate('{{ route('requests.create') }}');
          }
      "
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            // Forzar siempre modo claro en todos los dispositivos (móviles y escritorio)
            (function() {
                function applyTheme() {
                    localStorage.setItem('theme', 'light');
                    document.documentElement.classList.remove('dark');
                    document.documentElement.classList.add('light');
                }
                applyTheme();
                document.addEventListener('livewire:navigated', applyTheme);
            })();
        </script>

        <title>Suraki Tickets</title>

        <!-- Fonts -->
        <link rel="icon" type="image/png" href="{{ asset('icono.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-suraki-neutral dark:bg-[#09090a] text-suraki-secondary dark:text-zinc-100 transition-colors duration-200">
        <div class="flex h-screen overflow-hidden bg-suraki-neutral dark:bg-[#09090a] p-4 gap-4" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
            
            <!-- Sidebar -->
            <livewire:layout.navigation />

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                
                <!-- Topbar -->
                <div class="flex items-center justify-between bg-white dark:bg-zinc-900 p-4 rounded-2xl shadow-sm mb-4 border border-suraki-neutral-dark dark:border-zinc-800 transition-colors">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden mr-4 text-suraki-secondary dark:text-zinc-300 focus:outline-none" aria-label="Abrir menú de navegación">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-lg hidden md:block">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="topbar-search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg leading-5 bg-suraki-neutral dark:bg-zinc-800 placeholder-gray-500 dark:placeholder-zinc-400 text-suraki-secondary dark:text-zinc-100 focus:outline-none focus:ring-suraki-primary focus:border-suraki-primary sm:text-sm transition-colors duration-200" placeholder="Buscar (Presiona '/' para enfocar)...">
                        </div>
                    </div>
                    
                    <div class="md:hidden">
                        <img src="{{ asset('icono.png') }}" alt="Suraki Logo" class="h-8 w-auto">
                    </div>

                    <!-- Right side: Notifications & Profile -->
                    <div class="flex items-center ml-4 space-x-2 md:space-x-4">

                        <livewire:layout.notification-bell />
                        
                        <!-- Separator -->
                        <div class="hidden sm:block h-6 border-l border-suraki-neutral-dark dark:border-zinc-800"></div>

                        <livewire:layout.topbar-profile />
                    </div>
                </div>

                <!-- Page Content Scrollable Area -->
                <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                    <!-- Dynamic Breadcrumbs -->
                    <x-breadcrumbs />

                    <!-- Page Heading (Optional) -->
                    @if (isset($header))
                        <header class="bg-white dark:bg-zinc-900 shadow-sm rounded-2xl mb-4 p-6 hidden md:block border border-suraki-neutral-dark dark:border-zinc-800 transition-colors">
                            {{ $header }}
                        </header>
                    @endif

                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>

        <!-- Floating Action Button (FAB) para crear tickets en móvil -->
        <a href="{{ route('tickets.create') }}" wire:navigate class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-suraki-primary text-white rounded-full shadow-lg flex items-center justify-center hover:bg-suraki-primary-hover hover:scale-105 transition-transform z-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-suraki-primary">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>

        <!-- Global Toast Notification System -->
        <x-toast />

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

        <x-global-loader />

        <!-- Keyboard Shortcut Legend Modal -->
        <x-keyboard-help />

        <!-- Global confirmation modal -->
        <x-confirmation-modal />

        <script>
            // Solicitar permiso de Notificaciones Push al usuario
            document.addEventListener('DOMContentLoaded', () => {
                if ('Notification' in window && Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                    Notification.requestPermission();
                }
            });

            window.addEventListener('browser-push', event => {
                const title = event.detail.title || 'Suraki HelpDesk';
                const body = event.detail.body || 'Tienes una nueva notificación.';
                
                if ('Notification' in window && Notification.permission === 'granted') {
                    new Notification(title, {
                        body: body,
                        icon: '/favicon.ico',
                        tag: 'suraki-push'
                    });
                }
            });

            // Registro del Service Worker de Firebase para notificaciones Push en segundo plano (Móvil y PC)
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                    .then(reg => console.log('Firebase Service Worker registrado:', reg.scope))
                    .catch(err => console.error('Error registrando Firebase Service Worker:', err));
            }
        </script>
    </body>
</html>
