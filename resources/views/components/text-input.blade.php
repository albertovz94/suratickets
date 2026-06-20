@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-suraki-neutral-dark focus:border-suraki-primary focus:ring-suraki-primary rounded-lg shadow-sm transition-colors duration-150']) }}>
