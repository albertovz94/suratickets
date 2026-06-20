@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-suraki-secondary']) }}>
    {{ $value ?? $slot }}
</label>
