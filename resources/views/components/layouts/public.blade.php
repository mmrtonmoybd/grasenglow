@props([
    'seo',
    'structuredData' => [],
])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="color-scheme" content="light" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Caveat:wght@500;600&family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap"
            rel="stylesheet"
        />
        @if ($siteSettings->favicon)
            <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}" />
        @endif

        <x-seo :seo="$seo" :structured-data="$structuredData ?? []" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @php
        $headingFonts = ['Playfair Display' => "'Playfair Display', Georgia, serif", 'DM Sans' => "'DM Sans', sans-serif", 'Georgia' => 'Georgia, serif'];
        $bodyFonts = ['DM Sans' => "'DM Sans', sans-serif", 'Arial' => 'Arial, sans-serif', 'Georgia' => 'Georgia, serif'];
    @endphp

    <body
        class="selection:bg-sage/30 selection:text-pine font-sans antialiased"
        style="
            --color-forest: {{ $siteSettings->primary_color }};
            --color-pine: {{ $siteSettings->secondary_color }};
            --color-coral: {{ $siteSettings->accent_color }};
            --color-cream: {{ $siteSettings->background_color }};
            --color-ink: {{ $siteSettings->text_color }};
            --font-display: {{ $headingFonts[$siteSettings->heading_font] ?? $headingFonts['Playfair Display'] }};
            --font-sans: {{ $bodyFonts[$siteSettings->body_font] ?? $bodyFonts['DM Sans'] }};
        "
    >
        <a
            href="#main-content"
            class="focus-ring sr-only z-[100] rounded bg-white px-4 py-3 focus:not-sr-only focus:fixed focus:top-4 focus:left-4"
        >
            Skip to content
        </a>
        <x-public-header :site-settings="$siteSettings" :header-navigation="$headerNavigation" />
        <main id="main-content">
            {{ $slot }}
        </main>
        <x-public-footer
            :site-settings="$siteSettings"
            :footer-quick-navigation="$footerQuickNavigation"
            :footer-help-navigation="$footerHelpNavigation"
            :social-links="$socialLinks"
        />
    </body>
</html>
