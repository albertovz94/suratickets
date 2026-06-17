<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-suraki-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-suraki-primary-hover focus:bg-suraki-primary-hover active:bg-suraki-primary-hover focus:outline-none focus:ring-2 focus:ring-suraki-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm']) }}>
    {{ $slot }}
</button>
