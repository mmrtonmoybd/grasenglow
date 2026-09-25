<x-layouts.public :seo="$seo">
    <x-content-detail :record="$story" index-route="impact.index" index-label="Impact">
        <x-markdown :content="$story->body" />
    </x-content-detail>
</x-layouts.public>
