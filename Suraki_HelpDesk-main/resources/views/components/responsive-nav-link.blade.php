@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-suraki-primary text-start text-base font-medium text-suraki-primary bg-suraki-primary-light focus:outline-none focus:text-suraki-primary-hover focus:bg-red-100 focus:border-suraki-primary-hover transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-suraki-tertiary hover:text-suraki-secondary hover:bg-suraki-neutral hover:border-suraki-neutral-dark focus:outline-none focus:text-suraki-secondary focus:bg-suraki-neutral focus:border-suraki-neutral-dark transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
