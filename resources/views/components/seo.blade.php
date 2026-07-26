@props([
    'seo',
    'structuredData' => [],
])

<title>{{ $seo['title'] }}</title>
@if ($seo['description'])
    <meta name="description" content="{{ $seo['description'] }}" />
@endif

<link rel="canonical" href="{{ $seo['canonical'] }}" />
<meta name="robots" content="{{ $seo['indexable'] ? 'index,follow' : 'noindex,nofollow' }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $seo['title'] }}" />
@if ($seo['description'])
    <meta property="og:description" content="{{ $seo['description'] }}" />
@endif

<meta property="og:url" content="{{ $seo['canonical'] }}" />
@if ($seo['image'])
    <meta property="og:image" content="{{ asset('storage/' . $seo['image']) }}" />
@endif

<meta name="twitter:card" content="summary_large_image" />

@php
    $organization = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $seo['site']->organization_schema_name ?: $seo['site']->site_name,
        'description' => $seo['site']->organization_schema_description,
        'logo' => $seo['site']->organization_schema_logo ? asset('storage/' . $seo['site']->organization_schema_logo) : null,
        'url' => $seo['site']->canonical_domain ?: route('home'),
    ]);
    $schemas = array_values(array_filter([$organization, ...$structuredData]));
@endphp

@foreach ($schemas as $schema)
    <script type="application/ld+json">
        @json($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    </script>
@endforeach
