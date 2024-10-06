@php
    $headers = [
        ['key' => 'user_username', 'label' => __('User'), 'class' => 'w-30 text-white'],
        ['key' => 'title', 'label' => __('posts.Title'), 'class' => 'w-96 text-white'],
        ['key' => 'created_at', 'label' => __('Created At'), 'class' => 'text-white'],
    ];
@endphp

<div class="relative p-6 my-4 mb-10 rounded-lg shadow-md bg-surface-200" role="region"
    aria-labelledby="edit-article-header">

    {{-- Loading indicator --}}
    <span wire:loading class="absolute top-6 right-6 loading loading-spinner loading-md" aria-live="polite"
        aria-label="{{ __('Loading...') }}"></span>

    {{-- Page Header --}}
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

    <!-- Current Page Info -->
    <div aria-live="polite" class="text-sm text-gray-600">
        {{ __('Page') }} {{ $posts->currentPage() }} {{ __('of') }} {{ $posts->lastPage() }}
    </div>

    {{-- Posts table --}}
    <x-table :headers="$headers" :rows="$posts" :sort-by="$sortBy" wire:model="selected" selectable
        link="{{ Route('posts') }}/{id}">

        @scope('cell_user_username', $post)
            <div class="truncate max-w-30">
                {{ $post->user_username }}
            </div>
        @endscope

        @scope('cell_title', $post)
            <div class="truncate max-w-96 ">
                {{ $post->title }}
            </div>
        @endscope

        @scope('cell_created_at', $post)
            {{ $post->created_at->format('Y-m-d') }}
        @endscope

        @scope('actions', $post)
            <div class="flex gap-2">
                <x-button icon="o-pencil" wire:click="edit({{ $post->id }})" spinner
                    class="btn btn-sm btn-outline btn-info" aria-label="{{ __('Edit Post') }}"
                    tooltip="{{ __('Edit') }}" />
                <x-button icon="o-trash" wire:click="delete({{ $post->id }})" spinner
                    class="btn btn-sm btn-outline btn-error" aria-label="{{ __('Delete Post') }}"
                    tooltip="{{ __('Delete') }}" wire:confirm="{{ __('Are you sure you want to delete this post?') }}" />
            </div>
        @endscope
    </x-table>

    {{-- Delete Selected Posts Action Button --}}
    <div class="flex justify-end mt-4">
        <x-button label="{{ __('Delete Selected Posts') }}" icon="o-trash" wire:click="delete()" spinner
            class="btn btn-outline btn-error" aria-label="{{ __('Delete selected posts') }}" />
    </div>

    <!-- Pagination Links -->
    <div class="py-4" role="navigation" aria-label="{{ __('Pagination') }}">
        {{ $posts->links(data: ['scrollTo' => false]) }}
    </div>
</div>
