<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Suraki HelpDesk') }}</title>

        <!-- Fonts -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Full-screen split layout -->
        <div class="min-h-screen flex">
            <!-- Left Panel: Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-suraki-secondary relative overflow-hidden flex-col justify-between p-12">
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
                            <img src="{{ asset('images/logo.png') }}" alt="Suraki Logo" class="w-full h-full object-contain">
                        </div>
                        <span class="text-white font-heading text-2xl font-bold tracking-tight">Suraki</span>
                    </div>
                    <p class="text-white/50 text-sm font-mono">HelpDesk v1.0</p>
                </div>

                <!-- Center: Tagline -->
                <div class="relative z-10">
                    <h1 class="text-white font-heading text-4xl font-bold leading-tight mb-4">
                        Soporte TI<br>
                        <span class="text-suraki-primary">inteligente</span> y<br>
                        eficiente.
                    </h1>
                    <p class="text-white/60 text-lg max-w-md">
                        Gestiona incidencias, asigna técnicos y resuelve problemas desde un solo lugar.
                    </p>
                </div>

                <!-- Bottom: Footer -->
                <div class="relative z-10">
                    <p class="text-white/30 text-sm">&copy; {{ date('Y') }} Suraki. Departamento de Sistemas.</p>
                </div>
            </div>

            <!-- Right Panel: Content (Login Form) -->
            <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-suraki-neutral">
                <!-- Mobile Logo (visible on small screens) -->
                <div class="lg:hidden mb-8 flex justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Suraki HelpDesk Logo" class="w-auto h-14 object-contain">
                </div>

                <div class="w-full sm:max-w-md">
                    <div class="glass-panel px-8 py-10">
                        {{ $slot }}
                    </div>
                    <p class="text-center text-suraki-tertiary/60 text-xs mt-6 lg:hidden">&copy; {{ date('Y') }} Suraki. Departamento de Sistemas.</p>
                </div>
            </div>
        </div>
    </body>
</html>
