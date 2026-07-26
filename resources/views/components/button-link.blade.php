@props([
    'href',
    'variant' => 'primary',
])

<a
    href="{{ $href }}"
    {{
        $attributes->class([
            'focus-ring inline-flex items-center justify-center gap-3 rounded-full px-7 py-3.5 text-sm font-semibold transition hover:-translate-y-0.5',
            'bg-forest shadow-card hover:bg-pine text-white' => $variant === 'primary',
            'border-forest text-forest hover:bg-forest border hover:text-white' => $variant === 'secondary',
        ])
    }}
>
    {{ $slot }}
    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
        <path d="M5 12h14M14 7l5 5-5 5" />
    </svg>
</a>
