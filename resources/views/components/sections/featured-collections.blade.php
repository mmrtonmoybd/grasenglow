@props([
    'section',
    'collections',
])

<section class="mx-auto max-w-[1450px] px-4 py-8 sm:px-6 lg:px-10">
    <h2 class="font-display text-forest text-3xl">{{ $section->heading }}</h2>
    <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($collections as $collection)
            <a
                href="{{ route('collections.show', $collection) }}"
                class="focus-ring bg-paper shadow-card rounded-[20px] p-6"
            >
                <h3 class="font-display text-forest text-2xl">{{ $collection->name }}</h3>
                @if ($collection->short_description)
                    <p class="text-ink/70 mt-2 text-sm leading-6">{{ $collection->short_description }}</p>
                @endif
            </a>
        @endforeach
    </div>
</section>
