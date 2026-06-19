<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestión de Tickets') }}</title>

        <!-- Fonts -->
        <link rel="icon" type="image/png" href="{{ asset('icono.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        </div>
    </body>
</html>
