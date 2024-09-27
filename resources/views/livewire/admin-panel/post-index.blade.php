<div class="min-h-screen mb-10">

    <h2 class="py-5 text-xl font-semibold">{{ __('posts.Edit Article') }}</h2>

    <div class="p-6 bg-surface-300">

        <div class="flex items-center justify-between py-4">
            <!-- Search Input -->
            <x-input wire:model.live.500ms='search' name="search" placeholder="{{ __('Search') }}"
                icon="o-magnifying-glass" class="w-full bg-surface-300 placeholder-lime-shadow/50" />

            <!-- Pagination Size Selector -->
            <x-select icon="o-chevron-down" :options="$perPageOptions" option-label="name" option-value="value"
                wire:model.live="perPage" />
        </div>

        <!-- Current Page Info -->
        <div class="py-2 text-sm text-right text-gray-600">
            Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}
        </div>

        <!-- Posts List -->
        @foreach ($posts as $post)
            <x-list-item :item="$post" value="title" sub-value="created_at" avatar="avatar">
                <x-slot:value>
                    {{ $post->title }}
                </x-slot:value>
                <x-slot:sub-value>
                    {{ $post->created_at->format('Y-m-d') }}
                </x-slot:sub-value>
                <x-slot:actions>
                    <x-button icon="o-eye" class="btn-info" wire:click="viewPost({{ $post->id }})" />
                    <x-button icon="o-pencil" class="btn-warning" wire:click="editPost({{ $post->id }})" />
                    <x-button icon="o-trash" class="text-red-500" wire:click="deletePost({{ $post->id }})" />
                </x-slot:actions>
            </x-list-item>
        @endforeach

        <!-- Pagination Links -->
        <div class="py-4">
            {{ $posts->links(data: ['scrollTo' => false]) }}
        </div>

    </div>
</div>
