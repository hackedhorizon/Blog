<div class="flex flex-col items-center justify-center">

    <!-- Search Input -->
    <div class="w-full px-5 mx-5">
        <x-input wire:model.live.500ms='search' name="search" placeholder="{{ __('Search') }}" icon="o-magnifying-glass"
            class="w-full bg-surface-300 placeholder-lime-shadow/50" />
    </div>

    <!-- Articles Container -->
    <x-cards.article-card-container :pagination="true" :title="__('Articles')" :posts="$this->posts" />
</div>
