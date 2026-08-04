@props(['disabled' => false, 'type' => 'text'])

@if($type === 'password')
    <div x-data="{ show: false }" class="relative w-full">
        <input 
            :type="show ? 'text' : 'password'" 
            @disabled($disabled) 
            {{ $attributes->merge(['class' => 'border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm transition-colors duration-150 pr-10 w-full']) }}
        >
        <button 
            type="button" 
            @click="show = !show" 
            tabindex="-1"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors"
            title="Mostrar / Ocultar Contraseña"
        >
            <svg x-show="!show" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="show" class="w-5 h-5 text-suraki-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.03 10.03 0 012.122-.363c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21f-9-9M3 3l18 18" />
            </svg>
        </button>
    </div>
@else
    <input type="{{ $type }}" @disabled($disabled) {{ $attributes->merge(['class' => 'border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm transition-colors duration-150']) }}>
@endif
