<div class="relative w-full max-w-4xl min-h-screen p-6 mx-auto my-4 mb-10 rounded-lg shadow-md bg-surface-300"
    role="region" aria-labelledby="edit-article-header">

    <span wire:loading class="absolute top-6 left-6 loading loading-spinner loading-md" aria-live="polite"
        aria-label="{{ __('Loading...') }}"></span>

    <h2 id="edit-article-header" class="mb-5 text-2xl font-semibold text-center">{{ __('posts.Edit Article') }}</h2>

    <div class="flex items-center justify-between py-4">
        <!-- Search Input -->
        <div class="flex-grow">
            <x-input wire:model.live.500ms='search' name="search" placeholder="{{ __('Search') }}"
                icon="o-magnifying-glass" class="w-full text-gray-300 bg-surface-200 placeholder-lime-shadow/50"
                aria-label="{{ __('Search for posts') }}" />
        </div>

        <!-- Pagination Size Selector -->
        <x-select :options="$perPageOptions" option-label="name" option-value="value" wire:model.live="perPage" class="ml-2"
            aria-label="{{ __('Select number of items per page') }}" />
    </div>

    <div class="flex items-center justify-between py-2 mb-4 text-sm text-gray-600">
        <!-- Current Page Info -->
        <div aria-live="polite">
            {{ __('Page') }} {{ $posts->currentPage() }} {{ __('of') }} {{ $posts->lastPage() }}
        </div>

        <!-- Sort Controls -->
        <div class="flex space-x-2" aria-label="{{ __('Sort options') }}">
            <button wire:click="sortBy('title')" class="text-sm btn btn-outline btn-primary"
                aria-pressed="{{ $sortField === 'title' }}">
                {{ __('Title') }}
                @if ($sortField === 'title')
                    <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                @endif
            </button>

            <button wire:click="sortBy('created_at')" class="text-sm btn btn-outline btn-primary"
                aria-pressed="{{ $sortField === 'created_at' }}">
                {{ __('Created At') }}
                @if ($sortField === 'created_at')
                    <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                @endif
            </button>
        </div>
    </div>

    <!-- Posts List -->
    <div class="space-y-4" role="list">
        @foreach ($posts as $post)
            <x-list-item :item="$post" link="asd" value="title" sub-value="created_at" avatar="avatar"
                class="transition-colors duration-200 rounded-lg hover:bg-blue-800" role="listitem"
                aria-labelledby="post-title-{{ $post->id }}">
                <x-slot:value id="post-title-{{ $post->id }}">
                    {{ $post->title }}
                </x-slot:value>
                <x-slot:sub-value>
                    {{ $post->created_at->format('Y-m-d') }}
                </x-slot:sub-value>
                <x-slot:actions class="flex space-x-2">
                    <x-button icon="o-pencil" class="btn-warning btn-outline"
                        wire:click="editPost({{ $post->id }})"
                        aria-label="{{ __('Edit :title', ['title' => $post->title]) }}" />
                    <x-button icon="o-trash" class="btn-error btn-outline" wire:click="deletePost({{ $post->id }})"
                        aria-label="{{ __('Delete :title', ['title' => $post->title]) }}" />
                </x-slot:actions>
            </x-list-item>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="py-4" role="navigation" aria-label="{{ __('Pagination') }}">
        {{ $posts->links(data: ['scrollTo' => false]) }}
    </div>
</div>
