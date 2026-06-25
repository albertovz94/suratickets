<div x-data="{
        show: false,
        message: '',
        type: 'success',
        timeout: null,
        init() {
            if (this.$el.dataset.message) {
                this.message = this.$el.dataset.message;
                this.type = this.$el.dataset.type || 'success';
                this.showToast();
            }

            // Escuchar el evento de dispatch de Livewire 3
            window.addEventListener('notify', event => {
                const data = event.detail[0] || event.detail;
                this.message = data.message || data;
                this.type = data.type || 'success';
                this.showToast();
            });

            // Soportar SPA navigations en Livewire 3
            document.addEventListener('livewire:navigated', () => {
                if (this.$el.dataset.message) {
                    this.message = this.$el.dataset.message;
                    this.type = this.$el.dataset.type || 'success';
                    this.showToast();
                    // Limpiar para no repetir
                    this.$el.dataset.message = '';
                }
            });
        },
        showToast() {
            this.show = true;
            clearTimeout(this.timeout);
            // El toast dura 4 segundos en pantalla
            this.timeout = setTimeout(() => { this.show = false }, 4000);
        }
    }"
    data-message="{{ session('message', '') }}"
    data-type="{{ session('type', 'success') }}"
    class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[100] flex flex-col items-center pointer-events-none"
    style="display: none;"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-4"
>
    <!-- Fondo Glassmorphism -->
    <div class="pointer-events-auto flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl backdrop-blur-xl border bg-white/90"
         :class="{
             'border-green-200/50 shadow-green-500/10': type === 'success',
             'border-red-200/50 shadow-red-500/10': type === 'error',
             'border-blue-200/50 shadow-blue-500/10': type === 'info',
             'border-yellow-200/50 shadow-yellow-500/10': type === 'warning'
         }">
        
        <!-- Iconos dinámicos -->
        <div class="flex-shrink-0">
            <!-- Success Icon -->
            <svg x-show="type === 'success'" class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <!-- Error Icon -->
            <svg x-show="type === 'error'" class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <!-- Info Icon -->
            <svg x-show="type === 'info'" class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <!-- Warning Icon -->
            <svg x-show="type === 'warning'" class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Mensaje -->
        <p class="text-sm font-bold text-gray-800" x-text="message"></p>

        <!-- Botón cerrar -->
        <button @click="show = false" class="ml-2 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
