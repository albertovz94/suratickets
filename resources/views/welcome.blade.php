
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suraki HelpDesk</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-suraki-neutral text-suraki-secondary selection:bg-suraki-primary selection:text-white">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        <!-- Main Content -->
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:justify-center lg:col-start-2">
                    <h1 class="text-4xl font-bold font-heading text-suraki-secondary">
                        Suraki <span class="text-suraki-primary">HelpDesk</span>
                    </h1>
                </div>
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-suraki-secondary ring-1 ring-transparent transition hover:text-suraki-primary focus:outline-none focus-visible:ring-suraki-primary">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-suraki-secondary ring-1 ring-transparent transition hover:text-suraki-primary focus:outline-none focus-visible:ring-suraki-primary">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="mt-6 flex flex-col items-center">
                <div class="glass-panel p-10 text-center max-w-xl animate-slide-up">
                    <div class="w-20 h-20 bg-suraki-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 animate-float-glow">
                        <svg class="w-10 h-10 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-4">Soporte Técnico y Gestión</h2>
                    <p class="text-suraki-tertiary mb-8">
                        Sistema centralizado para el control de inventarios, roles, horarios y tickets de atención al usuario.
                    </p>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="blob-btn">
                                Ir al Dashboard
                                <span class="blob-btn__inner">
                                    <span class="blob-btn__blobs">
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                    </span>
                                </span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="blob-btn">
                                Ingresar al Sistema
                                <span class="blob-btn__inner">
                                    <span class="blob-btn__blobs">
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                    </span>
                                </span>
                            </a>
                        @endauth
                    @endif
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-suraki-tertiary">
                &copy; {{ date('Y') }} Suraki. Todos los derechos reservados.
            </footer>
            
            <!-- SVG Filter for Blob Button -->
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: none;">
                <defs>
                    <filter id="goo">
                        <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
                        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
                        <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
                    </filter>
                </defs>
            </svg>
        </div>
    </div>
</body>
</html>
