<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Suraki Soporte TI') }}</title>

        <!-- Fonts -->
        <link rel="icon" type="image/png" href="{{ asset('build/assets/icono.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" x-data="{ showLogin: false }">
        <!-- Full-screen split layout -->
        <div class="min-h-screen flex relative bg-cover bg-no-repeat" style="background-image: url('{{ asset('suraki FULLHDDDD.png') }}'); background-position: center calc(50% - 50px);">
            <!-- Left Panel: Branding -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12 pr-32 z-10">
                <!-- Decorative background elements -->
                <div class="absolute inset-0">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-suraki-primary/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-suraki-primary/5 rounded-full translate-x-1/3 translate-y-1/3"></div>
                    <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                </div>

                <!-- Top: Logo & Brand -->
                <div class="relative z-10">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center p-2 backdrop-blur-sm border border-white/20">
                            <img src="{{ asset('icono.png') }}" alt="Suraki Logo" class="w-full h-full object-contain">
                        </div>
                        <span class="text-white font-heading text-2xl font-bold tracking-tight"> <h1 class="text-white font-heading text-5xl font-bold leading-tight mb-4">
                        Soporte TI<br>
                         Inteligente,<br>
                        eficiente.
                    </h1></span>
                    </div>
                    <p class="text-white text-lg max-w-sm font-medium">
                        Gestiona incidencias, asigna técnicos y resuelve problemas desde un solo lugar.
                    </p>
                </div>

                <!-- Bottom: Footer -->
                <div class="relative z-10">
                    <p class="text-white text-sm">&copy; {{ date('Y') }} Suraki. Departamento de Sistemas.</p>
                </div>
            </div>

            <!-- Right Panel: Content Background -->
            <div class="hidden lg:block lg:w-1/2 relative">
            </div>

            <!-- Center Button when Login is hidden -->
            <div class="absolute inset-0 flex flex-col justify-center items-center px-6 py-12 z-40 pointer-events-none" x-show="!showLogin" x-transition.opacity.duration.300ms>
                <button @click="showLogin = true" class="blob-btn pointer-events-auto shadow-[0_4px_20px_rgba(255,30,30,0.5)] text-lg" style="max-width: 250px; border:none;">
                    <span style="position:relative; z-index: 10;">Iniciar Sesión</span>
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

            <!-- Centered Form Modal (Overlapping the split) -->
            <div class="absolute inset-0 flex flex-col justify-center items-center px-6 py-12 z-50" x-show="showLogin" style="display: none;">
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-md cursor-pointer" @click="showLogin = false" x-show="showLogin" x-transition.opacity.duration.300ms></div>

                <div class="w-full sm:max-w-xl relative z-10" x-show="showLogin" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                    <!-- Mobile Logo (visible on small screens) -->
                    <div class="lg:hidden mb-8 flex justify-center">
                        <img src="{{ asset('icono.png') }}" alt="Suraki HelpDesk Logo" class="w-auto h-14 object-contain drop-shadow-lg">
                    </div>
                    
                    <div class="glass-panel px-12 sm:px-16 py-8 shadow-2xl bg-white/95 backdrop-blur-xl rounded-xl border border-white/50 relative">
                        <!-- Close button -->
                        <button type="button" @click="showLogin = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-full p-1 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>

                        {{ $slot }}
                    </div>
                    <p class="text-center text-white/70 text-xs mt-6 lg:hidden">&copy; {{ date('Y') }} Suraki. Departamento de Sistemas.</p>
                </div>
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

        <x-toast />
        <x-global-loader />
    </body>
</html>
