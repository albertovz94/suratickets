<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-suraki-neutral-dark rounded-lg font-semibold text-xs text-suraki-tertiary uppercase tracking-widest shadow-sm hover:bg-suraki-neutral focus:outline-none focus:ring-2 focus:ring-suraki-tertiary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
