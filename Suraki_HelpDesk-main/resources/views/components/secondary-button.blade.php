<button {{ $attributes->merge(['type' => 'button', 'class' => 'blob-btn inline-flex items-center font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-suraki-tertiary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm']) }} style="padding: 12px 16px; width: auto; font-size: 12px; border:none;">
    <span style="position:relative; z-index: 10;">{{ $slot }}</span>
    <span class="blob-btn__inner">
        <span class="blob-btn__blobs">
            <span class="blob-btn__blob"></span>
            <span class="blob-btn__blob"></span>
            <span class="blob-btn__blob"></span>
            <span class="blob-btn__blob"></span>
        </span>
    </span>
</button>
