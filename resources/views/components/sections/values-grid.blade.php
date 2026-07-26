@props([
    'section',
    'values',
])

<section id="what-we-do" class="mx-auto max-w-[1450px] px-4 py-8 sm:px-6 lg:px-10">
    @if ($section->heading)
        <h2
            class="leaf-line font-display text-forest flex items-center justify-center text-center text-3xl sm:text-4xl"
        >
            {{ $section->heading }}
        </h2>
    @endif

    <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($values as $value)
            <article class="border-forest/8 bg-paper shadow-card rounded-[20px] border p-6">
                <span
                    class="bg-sage/15 text-forest grid h-12 w-12 place-items-center rounded-full text-xl"
                    aria-hidden="true"
                >
                    {{ match ($value->icon) {'leaf' => '❧','hand' => '✦','people' => '♙', default => '♡',} }}
                </span>
                <h3 class="font-display text-forest mt-3 text-xl">{{ $value->title }}</h3>
                @if ($value->description)
                    <p class="text-ink/70 mt-2 text-sm leading-6">{{ $value->description }}</p>
                @endif
            </article>
        @endforeach
    </div>
</section>
