@php
    $articleSchema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->title,
        'description' => strip_tags($post->excerpt),
        'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : null,
        'datePublished' => $post->published_at?->toAtomString(),
        'dateModified' => $post->updated_at?->toAtomString(),
        'author' => $post->author ? ['@type' => 'Person', 'name' => $post->author->name] : null,
    ]);
@endphp

<x-layouts.public :seo="$seo" :structured-data="[$articleSchema]">
    <article class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:py-20">
        <nav class="text-ink/55 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('news.index') }}">News</a>
            / {{ $post->title }}
        </nav>
        <h1 class="font-display text-forest mt-5 text-4xl sm:text-6xl">{{ $post->title }}</h1>
        @if ($post->published_at)
            <time class="text-ink/55 mt-4 block text-sm" datetime="{{ $post->published_at->toDateString() }}">
                {{ $post->published_at->toFormattedDateString() }} · {{ $post->reading_time }} min read
            </time>
        @endif

        @if ($post->featured_image)
            <x-public-image
                :path="$post->featured_image"
                :alt="$post->featured_image_alt"
                width="1200"
                height="700"
                loading="eager"
                fetchpriority="high"
                class="mt-8 aspect-[16/9] w-full rounded-[24px] bg-cream/40 object-contain"
            />
        @endif

        <div class="prose-content text-ink/80 mt-9">{{ $post->body }}</div>
    </article>
</x-layouts.public>
