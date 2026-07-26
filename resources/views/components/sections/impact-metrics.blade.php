@props([
    'section',
    'metrics',
])

<section id="impact-metrics" class="relative z-10 mx-auto -mt-3 max-w-[1450px] px-4 pb-4 sm:px-6 lg:-mt-16 lg:px-10">
    <div class="torn-edge paper-texture shadow-paper rounded-[28px] px-4 pt-7 pb-7 sm:px-8 sm:pt-9 lg:px-10">
        @if ($section->heading)
            <h2
                class="leaf-line font-display text-forest flex items-center justify-center text-center text-2xl font-semibold sm:text-3xl"
            >
                {{ $section->heading }}
            </h2>
        @endif

        <div class="mt-7 grid grid-cols-2 gap-y-7 sm:grid-cols-3 lg:grid-cols-7 lg:gap-0">
            @foreach ($metrics as $metric)
                <article class="stat-card relative px-3 text-center">
                    <span
                        class="bg-sage/15 text-forest mx-auto grid h-11 w-11 place-items-center rounded-full text-2xl"
                        aria-hidden="true"
                    >
                        {{ match ($metric->icon) {'recycle' => '↻','bag' => '◫','shop' => '⌂','people' => '♙','paw' => '♣','heart' => '♡', default => '✦',} }}
                    </span>
                    <div class="font-display text-forest mt-2 text-3xl font-semibold">
                        {{ $metric->prefix }}{{ $metric->display_value }}{{ $metric->suffix }}
                        @if ($metric->unit)
                            <span class="font-sans text-xs">{{ $metric->unit }}</span>
                        @endif
                    </div>
                    @if ($metric->description)
                        <p class="text-ink/75 mt-1 text-xs leading-5">{{ $metric->description }}</p>
                    @endif
                </article>
            @endforeach
        </div>

        @if ($section->body)
            <div
                class="bg-sage/15 text-forest mx-auto mt-6 flex max-w-4xl items-center justify-center gap-3 rounded-full px-5 py-3 text-center text-sm"
            >
                <span aria-hidden="true">❧</span>
                <span>{{ $section->body }}</span>
                <span class="text-coral" aria-hidden="true">♡</span>
            </div>
        @endif
    </div>
</section>
