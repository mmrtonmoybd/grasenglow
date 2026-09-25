@props([
    'section',
])

<section class="mx-auto max-w-5xl px-4 py-10 sm:px-6">
    @if ($section->eyebrow)
        <p class="text-forest text-xs font-semibold tracking-wider uppercase">{{ $section->eyebrow }}</p>
    @endif

    @if ($section->heading)
        <h2 class="font-display text-forest mt-2 text-3xl sm:text-4xl">{{ $section->heading }}</h2>
    @endif

    @if ($section->subheading)
        <p class="text-ink/70 mt-2 text-lg">{{ $section->subheading }}</p>
    @endif

    <x-markdown :content="$section->body" class="text-ink/80 mt-5" />
</section>
