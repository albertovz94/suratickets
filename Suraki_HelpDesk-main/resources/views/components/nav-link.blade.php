@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-suraki-primary text-sm font-medium leading-5 text-suraki-secondary focus:outline-none focus:border-suraki-primary-hover transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-suraki-tertiary hover:text-suraki-secondary hover:border-suraki-neutral-dark focus:outline-none focus:text-suraki-secondary focus:border-suraki-neutral-dark transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
