<button {{ $attributes->merge(['type' => 'submit', 'class' => 'blob-btn blob-btn--danger inline-flex items-center justify-center font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-sm']) }}>
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

