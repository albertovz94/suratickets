@php
    $breadcrumbs = $breadcrumbs ?? [];
@endphp
@if (count($breadcrumbs) > 1)
    <nav class="flex px-4 py-2.5 text-xs font-semibold text-suraki-tertiary dark:text-zinc-400 bg-white dark:bg-zinc-900 border border-suraki-neutral-dark dark:border-zinc-800 rounded-xl shadow-sm mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            @foreach ($breadcrumbs as $index => $crumb)
                <li class="inline-flex items-center">
                    @if ($index > 0)
                        <svg class="w-3.5 h-3.5 text-gray-400 dark:text-zinc-650 mx-1 md:mx-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                    
                    @if ($crumb['url'] && $index < count($breadcrumbs) - 1)
                        <a href="{{ $crumb['url'] }}" wire:navigate class="inline-flex items-center text-suraki-tertiary dark:text-zinc-400 hover:text-suraki-primary dark:hover:text-suraki-primary transition-colors">
                            @if (($crumb['icon'] ?? null) === 'home')
                                <svg class="w-4 h-4 mr-1.5 text-suraki-tertiary/70 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            @endif
                            {{ $crumb['label'] }}
                        </a>
                    @else
                        <span class="inline-flex items-center text-suraki-secondary dark:text-zinc-200 font-bold">
                            {{ $crumb['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
