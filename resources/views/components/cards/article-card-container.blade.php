<div class="flex flex-col max-w-screen-xl gap-10 p-5 m-5 tracking-normal shadow-lg bg-surface-200">
    {{-- Header with title and explore more link --}}
    <div class="flex flex-row items-end justify-between">
        <h1 class="text-2xl md:text-4xl">{{ $title }}</h1>
        {{-- Conditionally display Explore More text --}}
        @if (isset($exploreMoreText))
            <p class="items-center text-base cursor-pointer">
                {{ $exploreMoreText }}
                @svg('ri-arrow-right-double-line', ['class' => 'w-5 inline transition-all duration-300'])
            </p>
        @endif
    </div>

    {{-- Grid of articles --}}
    <div class="grid grid-cols-1 cursor-pointer gap-7 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($posts as $post)
            @include('components.cards.article-card', [
                'id' => $post->id,
                'image' => $post->image ?? 'https://picsum.photos/500/350',
                'date' => $post->created_at->format('M d, Y'),
                'categories' => $post->categories->pluck('name')->implode(', '),
                'title' => $post->translated_title,
                'author' => $post->user->name,
            ])
        @endforeach
    </div>

    {{-- Conditionally display pagination links --}}
    @if (isset($pagination) && $pagination === true)
        {{ $posts->links(data: ['scrollTo' => false]) }}
    @endif
</div>
