<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('solicitudes.index') }}" wire:navigate class="p-2 text-gray-400 hover:text-suraki-primary bg-white rounded-xl shadow-sm border border-gray-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nueva Solicitud de Equipo</h2>
            <p class="text-sm text-gray-500">Ingresa los detalles del equipo IT que necesitas.</p>
        </div>
    </div>

    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-suraki-neutral-dark p-6 md:p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="tipo_equipo" class="block text-sm font-bold text-gray-700 mb-2">Equipo Solicitado</label>
                <input type="text" wire:model="tipo_equipo" id="tipo_equipo" 
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 focus:bg-white transition-colors"
                    placeholder="Ej. Monitor, Teclado, Ratón, Laptop..." required>
                @error('tipo_equipo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tu Departamento</label>
                <div class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-2.5 text-gray-600 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    {{ auth()->user()->departamento->nombre ?? 'Sin departamento asignado' }}
                </div>
                <p class="text-xs text-gray-400 mt-1">Este dato se enviará automáticamente con tu solicitud.</p>
            </div>
        </div>

        <div>
            <label for="descripcion" class="block text-sm font-bold text-gray-700 mb-2">Justificación o Detalles</label>
            <textarea wire:model="descripcion" id="descripcion" rows="4" 
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-suraki-primary focus:ring-suraki-primary bg-gray-50 focus:bg-white transition-colors resize-none"
                placeholder="Explica para qué necesitas el equipo o alguna característica especial..." required></textarea>
            @error('descripcion') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-suraki-primary hover:bg-suraki-secondary text-white font-bold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span>Enviar Solicitud</span>
            </button>
        </div>
    </form>
</div>
