<x-layouts.public :seo="$seo">
    <section class="mx-auto max-w-[1450px] px-4 py-14 sm:px-6 lg:px-10">
        <h1 class="font-display text-forest text-5xl sm:text-6xl">Projects</h1>
        <div class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($projects as $project)
                <x-content-card :record="$project" route="projects.show" />
            @empty
                <p>No projects are published yet.</p>
            @endforelse
        </div>
        <div class="mt-9">{{ $projects->links() }}</div>
    </section>
</x-layouts.public>
