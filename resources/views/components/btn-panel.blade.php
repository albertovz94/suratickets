@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'blob-btn']) }}>
    <span style="position:relative; z-index: 10;" class="flex items-center gap-2">
        {{ $slot }}
    </span>
    <span class="blob-btn__inner">
        <span class="blob-btn__blobs">
            <span class="blob-btn__blob"></span>
            <span class="blob-btn__blob"></span>
            <span class="blob-btn__blob"></span>
            <span class="blob-btn__blob"></span>
        </span>
    </span>
</button>
