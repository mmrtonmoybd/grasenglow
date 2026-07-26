<x-layouts.public :seo="$seo">
    <x-content-detail :record="$story" index-route="impact.index" index-label="Impact">
        @if ($story->body)
            <p>{{ $story->body }}</p>
        @endif
    </x-content-detail>
</x-layouts.public>
