<x-layouts.public :seo="$seo">
    @foreach ($page->sections as $section)
        @switch($section->section_type->value)
            @case('hero')
                <x-sections.hero :section="$section" :slides="$heroSlides" />

                @break
            @case('impact_metrics')
                <x-sections.impact-metrics :section="$section" :metrics="$impactMetrics" />

                @break
            @case('brand_story')
                <x-sections.brand-story :section="$section" />

                @break
            @case('mission')
                <x-sections.mission :section="$section" />

                @break
            @case('values_grid')
                <x-sections.values-grid :section="$section" :values="$brandValues" />

                @break
            @case('product_categories')
                <x-sections.product-categories :section="$section" :categories="$productCategories" />

                @break
            @case('featured_products')
                <x-sections.featured-products :section="$section" :products="$featuredProducts" />

                @break
            @case('featured_collections')
                <x-sections.featured-collections :section="$section" :collections="$featuredCollections" />

                @break
            @case('contact_cta')
                <x-sections.contact-cta :section="$section" />

                @break
            @default
                <x-sections.default :section="$section" />
        @endswitch
    @endforeach
</x-layouts.public>
