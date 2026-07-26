<x-layouts.public :seo="$seo">
    <section class="mx-auto max-w-[1450px] px-4 py-14 sm:px-6 lg:px-10">
        <h1 class="font-display text-forest text-5xl sm:text-6xl">Impact Stories</h1>
        <div class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($stories as $story)
                <x-content-card :record="$story" route="impact.show" />
            @empty
                <p>No impact stories are published yet.</p>
            @endforelse
        </div>
        <div class="mt-9">{{ $stories->links() }}</div>
    </section>
</x-layouts.public>
