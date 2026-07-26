@php
    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'ScholarlyArticle',
        'headline' => $publication->title,
        'description' => strip_tags($publication->abstract),
        'datePublished' => $publication->publication_date?->toDateString(),
        'author' => $publication->authors ? ['@type' => 'Person', 'name' => $publication->authors] : null,
    ]);
@endphp

<x-layouts.public :seo="$seo" :structured-data="[$schema]">
    <x-content-detail :record="$publication" index-route="research.index" index-label="Research">
        @if ($publication->abstract)
            <h2>Abstract</h2>
            <p>{{ $publication->abstract }}</p>
        @endif

        @if ($publication->authors)
            <h2>Authors</h2>
            <p>{{ $publication->authors }}</p>
        @endif

        @if ($publication->external_url)
            <p>
                <a
                    class="text-forest font-semibold underline"
                    href="{{ $publication->external_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    View verified external publication
                </a>
            </p>
        @endif
    </x-content-detail>
</x-layouts.public>
