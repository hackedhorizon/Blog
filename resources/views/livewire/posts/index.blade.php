<div class="flex flex-col max-w-screen-xl gap-10 p-10 mx-auto tracking-normal">

    {{-- Header with title and explore more link --}}
    <div class="flex flex-row items-end justify-between">
        <h1 class="text-4xl font-normal">{{ __('Articles') }}</h1>
        <p class="items-center text-base cursor-pointer">
            Explore More
            @svg('ri-arrow-right-double-line', ['class' => 'w-5 inline transition-all duration-300'])
        </p>
    </div>

    {{-- Grid of articles --}}
    <div class="grid grid-cols-1 cursor-pointer gap-7 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($this->posts as $post)
            @include('components.cards.article-card', [
                'id' => $post->id,
                'image' => 'https://picsum.photos/500/350',
                'date' => $post->created_at->format('M d, Y'),
                'categories' => $post->categories->pluck('name')->implode(', '),
                'title' => $post->title,
                'author' => $post->user->name,
            ])
        @endforeach
    </div>

    {{-- Pagination links --}}
    {{ $this->posts->links(data: ['scrollTo' => false]) }}
</div>
