@php
    $faqSchema = $faqs->isNotEmpty()
        ? [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs
                ->map(
                    fn ($faq) => [
                        '@type' => 'Question',
                        'name' => $faq->question,
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($faq->answer)],
                    ],
                )
                ->values()
                ->all(),
        ]
        : null;
@endphp

<x-layouts.public :seo="$seo" :structured-data="array_filter([$faqSchema])">
    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:py-20">
        <nav class="text-ink/55 mb-7 text-sm" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a class="hover:text-forest" href="{{ route('home') }}">Home</a></li>
                <li aria-hidden="true">/</li>
                <li aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
        <h1 class="font-display text-forest text-4xl sm:text-6xl">{{ $page->hero_title ?: $page->title }}</h1>
        @if ($page->hero_subtitle)
            <p class="font-script text-coral mt-3 text-3xl">{{ $page->hero_subtitle }}</p>
        @endif

        @if ($page->hero_description)
            <p class="text-ink/75 mt-6 max-w-3xl text-lg leading-8">{{ $page->hero_description }}</p>
        @endif

        @if ($page->hero_image)
            <x-public-image
                :path="$page->hero_image"
                :alt="$page->hero_image_alt"
                width="1200"
                height="630"
                loading="eager"
                fetchpriority="high"
                class="shadow-card mt-8 aspect-[16/8] w-full rounded-[24px] object-cover"
            />
        @endif

        @if ($page->body)
            <div class="prose-content text-ink/80 mt-8 max-w-4xl text-base">{{ $page->body }}</div>
        @endif
    </section>

    @foreach ($page->sections as $section)
        <x-sections.default :section="$section" />
    @endforeach

    @if ($faqs->isNotEmpty())
        <section class="mx-auto max-w-4xl px-4 pb-16 sm:px-6">
            <h2 class="font-display text-forest text-3xl">Frequently Asked Questions</h2>
            <div class="mt-6 grid gap-3">
                @foreach ($faqs as $faq)
                    <details class="border-forest/10 bg-paper shadow-card rounded-2xl border p-5">
                        <summary class="focus-ring text-forest cursor-pointer rounded font-semibold">
                            {{ $faq->question }}
                        </summary>
                        <p class="text-ink/75 mt-4 text-sm leading-7 whitespace-pre-line">{{ $faq->answer }}</p>
                    </details>
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.public>
