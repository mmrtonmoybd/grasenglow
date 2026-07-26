@props([
    'path',
    'alt',
    'width',
    'height',
    'loading' => 'lazy',
    'fetchpriority' => 'auto',
])

@if ($path)
    <img
        src="{{ asset('storage/' . $path) }}"
        alt="{{ $alt }}"
        width="{{ $width }}"
        height="{{ $height }}"
        loading="{{ $loading }}"
        fetchpriority="{{ $fetchpriority }}"
        decoding="async"
        {{ $attributes }}
    />
@endif
