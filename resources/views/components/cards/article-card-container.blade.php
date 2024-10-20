<div class="flex flex-col max-w-screen-xl gap-10 p-5 m-5 tracking-normal shadow-lg bg-surface-200">
    {{-- Header --}}
    <div class="flex items-end justify-between">
        <h1 class="text-2xl md:text-4xl">{{ $title }}</h1>

        {{-- Explore More Link (if available) --}}
        @if (!empty($exploreMoreText))
            <p class="flex items-center text-base cursor-pointer">
                {{ $exploreMoreText }}
                @svg('ri-arrow-right-double-line', ['class' => 'w-5 inline transition-all duration-300'])
            </p>
        @endif
    </div>

    {{-- Articles Grid or Empty Message --}}
    @if ($posts->isNotEmpty())
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
    @else
        <p>{{ __('posts.empty') }}</p>
    @endif

    {{-- Conditionally display pagination links --}}
    @if (isset($pagination) && $pagination === true)
        {{ $posts->links(data: ['scrollTo' => false]) }}
    @endif
</div>
