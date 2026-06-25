<div id="global-loader" class="fixed inset-0 z-[100] hidden items-center justify-center bg-suraki-secondary/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="glass-panel p-8 text-center flex flex-col items-center max-w-sm w-full mx-4 shadow-2xl border-suraki-primary/20 transform scale-95 transition-transform duration-300" id="global-loader-content">
        <div class="relative w-28 h-28 mb-6 flex items-center justify-center">
            <div class="absolute inset-0 bg-suraki-primary/30 rounded-full animate-ping opacity-75"></div>
            <div class="relative w-24 h-24 bg-white rounded-full flex items-center justify-center border-4 border-suraki-primary shadow-[0_0_20px_rgba(255,30,30,0.4)] overflow-hidden z-10 animate-float-glow">
                <img src="{{ asset('icono.png') }}" alt="Cargando..." class="w-full h-full object-cover scale-110" />
            </div>
        </div>
        <h3 id="global-loader-message" class="text-xl font-bold text-suraki-secondary font-heading mb-2">Procesando...</h3>
        <p class="text-sm text-suraki-tertiary">Por favor, espera un momento</p>
        <div class="w-full h-1.5 bg-suraki-neutral-dark rounded-full mt-6 overflow-hidden relative">
            <div class="absolute top-0 left-0 h-full bg-suraki-primary rounded-full animate-pulse w-full"></div>
        </div>
    </div>
</div>

<script>
    window.useLoading = function() {
        const loader = document.getElementById('global-loader');
        const content = document.getElementById('global-loader-content');
        const messageElement = document.getElementById('global-loader-message');
        
        return {
            show: (message = 'Procesando...', duration = null) => {
                if(message) messageElement.innerText = message;
                loader.classList.remove('hidden');
                loader.classList.add('flex');
                setTimeout(() => {
                    loader.classList.remove('opacity-0');
                    loader.classList.add('opacity-100');
                    content.classList.remove('scale-95');
                    content.classList.add('scale-100');
                }, 10);

                if (duration) {
                    setTimeout(() => {
                        window.useLoading().hide();
                    }, duration);
                }
            },
            hide: () => {
                loader.classList.remove('opacity-100');
                loader.classList.add('opacity-0');
                content.classList.remove('scale-100');
                content.classList.add('scale-95');
                setTimeout(() => {
                    loader.classList.remove('flex');
                    loader.classList.add('hidden');
                }, 300);
            }
        };
    };

    // Listen to form submissions globally
    document.addEventListener('submit', function (event) {
        const form = event.target;
        // Verify it is a Livewire form being submitted
        if (form.tagName === 'FORM' && form.hasAttribute('wire:submit')) {
            // Check if it's the login form to prevent overriding its own submit
            if (!form.hasAttribute('x-on:submit')) {
                // Default 30 seconds duration for generic form submissions
                window.useLoading().show('Procesando...', 30000);
            }
        }
    });

    // Event listener for backend dispatch
    window.addEventListener('show-loader', (event) => {
        const detail = event.detail || {};
        const message = detail.message || 'Procesando...';
        const duration = detail.duration || 30000;
        window.useLoading().show(message, duration);
    });
    
    // Hide loader on livewire page navigations to prevent it from getting stuck
    document.addEventListener('livewire:navigated', () => {
        window.useLoading().hide();
    });
</script>
