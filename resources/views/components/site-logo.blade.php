@props([
    'settings',
    'compact' => false,
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    @if ($settings->logo)
        <img
            src="{{ asset('storage/' . $settings->logo) }}"
            alt="{{ $settings->site_name }}"
            width="62"
            height="72"
            class="{{ $compact ? 'h-12 w-10' : 'h-14 w-11' }} object-contain"
        />
    @else
        <svg
            viewBox="0 0 62 72"
            class="{{ $compact ? 'h-12 w-10' : 'h-14 w-11' }} text-forest"
            fill="none"
            aria-hidden="true"
        >
            <path d="M29 69C27 50 28 31 33 8" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" />
            <path
                d="M31 53C20 49 13 42 9 31c11 1 19 8 22 22Z"
                fill="#cbd2bb"
                stroke="currentColor"
                stroke-width="1.4"
            />
            <path
                d="M30 39C39 35 46 28 48 18c-10 2-16 8-18 21Z"
                fill="#dfe4d3"
                stroke="currentColor"
                stroke-width="1.4"
            />
            <path d="M31 27C22 24 17 18 15 9c9 2 15 8 16 18Z" fill="#b8c2a5" stroke="currentColor" stroke-width="1.4" />
        </svg>
    @endif

    <span>
        <span class="font-display text-ink block text-[1.65rem] leading-none tracking-tight">
            {{ $settings->site_name }}
        </span>
        @if ($settings->primary_tagline)
            <span class="text-forest/80 mt-1 block text-[10px] font-medium tracking-wide">
                {{ $settings->primary_tagline }}
            </span>
        @endif
    </span>
</span>
