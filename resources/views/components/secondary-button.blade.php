@props(['href' => null])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'blob-btn blob-btn--secondary inline-flex items-center justify-center font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 shadow-sm']) }}>
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
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'blob-btn blob-btn--secondary inline-flex items-center justify-center font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 shadow-sm']) }}>
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
@endif
