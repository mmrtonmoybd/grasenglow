@props([
    'record',
    'indexRoute',
    'indexLabel',
])

<article class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:py-20">
    <nav class="text-ink/55 text-sm" aria-label="Breadcrumb">
        <a href="{{ route($indexRoute) }}">{{ $indexLabel }}</a>
        / {{ $record->title }}
    </nav>
    <h1 class="font-display text-forest mt-5 text-4xl sm:text-6xl">{{ $record->title }}</h1>
    @if ($record->featured_image)
        <x-public-image
            :path="$record->featured_image"
            :alt="$record->featured_image_alt"
            width="1200"
            height="700"
            loading="eager"
            fetchpriority="high"
            class="mt-8 aspect-[16/9] w-full rounded-[24px] bg-cream/40 object-contain"
        />
    @endif

    @if ($record->description ?? null)
        <p class="prose-content text-ink/80 mt-8">{{ $record->description }}</p>
    @endif

    <div class="prose-content text-ink/80 [&_h2]:font-display [&_h2]:text-forest mt-8 grid gap-4 [&_h2]:text-2xl">
        {{ $slot }}
    </div>
</article>
