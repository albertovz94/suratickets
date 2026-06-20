<button {{ $attributes->merge(['type' => 'submit', 'class' => 'blob-btn inline-flex items-center font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-suraki-primary focus:ring-offset-2 shadow-sm']) }} style="padding: 12px 16px; width: auto; font-size: 12px; border:none;">
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
