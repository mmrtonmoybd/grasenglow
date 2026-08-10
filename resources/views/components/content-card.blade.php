@props([
    'record',
    'route',
])

<article class="border-forest/8 bg-paper shadow-card overflow-hidden rounded-[20px] border">
    @if ($record->featured_image)
        <a href="{{ route($route, $record) }}" class="block aspect-[5/3] overflow-hidden bg-cream/40">
            <x-public-image
                :path="$record->featured_image"
                :alt="$record->featured_image_alt"
                width="700"
                height="420"
                class="h-full w-full object-contain"
            />
        </a>
    @endif

    <div class="p-6">
        <h2 class="font-display text-forest text-2xl">
            <a href="{{ route($route, $record) }}">{{ $record->title }}</a>
        </h2>
        @if ($record->excerpt ?? ($record->short_description ?? null))
            <p class="text-ink/70 mt-3 text-sm leading-6">{{ $record->excerpt ?? $record->short_description }}</p>
        @endif

        <a href="{{ route($route, $record) }}" class="focus-ring text-forest mt-5 inline-block rounded font-semibold">
            Read more →
        </a>
    </div>
</article>
