<x-layouts.public :seo="$seo">
    <section class="mx-auto max-w-[1450px] px-4 py-14 sm:px-6 lg:px-10">
        <nav class="text-ink/55 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('products.index') }}">Products</a>
            / {{ $category->name }}
        </nav>
        <h1 class="font-display text-forest mt-5 text-5xl">{{ $category->name }}</h1>
        @if ($category->description || $category->short_description)
            <p class="text-ink/70 mt-4 max-w-3xl leading-7">
                {{ $category->description ?: $category->short_description }}
            </p>
        @endif

        <div class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p>No published products are currently listed in this category.</p>
            @endforelse
        </div>
        <div class="mt-9">{{ $products->links() }}</div>
    </section>
</x-layouts.public>
