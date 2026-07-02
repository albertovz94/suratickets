<div x-data="{
    open: false,
    title: '',
    message: '',
    confirmText: 'Confirmar',
    cancelText: 'Cancelar',
    action: null,
    confirm() {
        if (this.action) this.action();
        this.open = false;
    }
}"
x-show="open"
x-on:open-confirmation.window="
    title = $event.detail.title;
    message = $event.detail.message;
    confirmText = $event.detail.confirmText || 'Confirmar';
    cancelText = $event.detail.cancelText || 'Cancelar';
    action = $event.detail.action;
    open = true;
"
x-on:keydown.escape.window="open = false"
class="fixed inset-0 z-[100] overflow-y-auto"
style="display: none;"
role="dialog"
aria-modal="true"
>
    <!-- Backdrop with blur -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="open = false"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-zinc-900 p-6 shadow-2xl border border-gray-100 dark:border-zinc-800 transition-all transform animate-fade-in">
            <!-- Header/Icon -->
            <div class="flex items-center gap-4 text-red-600 dark:text-red-500 mb-4">
                <div class="p-3 bg-red-50 dark:bg-red-950/30 rounded-full">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100" x-text="title"></h3>
            </div>
            
            <p class="text-sm text-gray-600 dark:text-zinc-400 mb-6" x-text="message"></p>
            
            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <button @click="open = false" class="px-4 py-2 border border-gray-300 dark:border-zinc-700 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 text-sm font-semibold rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    <span x-text="cancelText"></span>
                </button>
                <button @click="confirm()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <span x-text="confirmText"></span>
                </button>
            </div>
        </div>
    </div>
</div>
