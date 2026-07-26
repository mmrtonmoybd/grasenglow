@php
    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => $project->title,
        'description' => strip_tags($project->short_description ?: $project->description),
        'image' => $project->featured_image ? asset('storage/' . $project->featured_image) : null,
        'dateCreated' => $project->start_date?->toDateString(),
    ]);
@endphp

<x-layouts.public :seo="$seo" :structured-data="[$schema]">
    <x-content-detail :record="$project" index-route="projects.index" index-label="Projects">
        @if ($project->objective)
            <h2>Objective</h2>
            <p>{{ $project->objective }}</p>
        @endif

        @if ($project->methodology)
            <h2>Methodology</h2>
            <p>{{ $project->methodology }}</p>
        @endif

        @if ($project->results)
            <h2>Results</h2>
            <p>{{ $project->results }}</p>
        @endif
    </x-content-detail>
</x-layouts.public>
