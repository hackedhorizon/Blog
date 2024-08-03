<a id="{{ $id }}" wire:key="{{ $id }}" class="max-w-96" href="posts/{{ $id }}" wire:navigate>
    <div
        class="transition-all duration-300 rounded-md shadow-xl card bg-base-100 md:hover:-translate-y-5 md:hover:rotate-2">

        {{-- Article cover image --}}
        <figure>
            <img loading="lazy" src="{{ $image }}" class="w-full" alt="Article cover image" />
        </figure>

        {{-- Article details --}}
        <div class="p-5 text-primary-500 card-body">

            {{-- Article creation time and category --}}
            <p class="w-full text-xs font-thin line-clamp-1">
                {{ $date }} - {{ $categories }}
            </p>

            {{-- Title and action icons --}}
            <div class="flex justify-between gap-2">
                <h2 class="text-2xl line-clamp-2">{{ $title }}</h2>
                <div class="min-w-16 flex-nowrap">
                    <x-heroicon-o-share
                        class="inline w-6 h-auto transition-all duration-300 hover:fill-primary-100 hover:text-primary-100" />
                    <x-heroicon-o-heart
                        class="inline w-6 h-auto transition-all duration-300 hover:fill-primary-100 hover:text-primary-100" />
                </div>
            </div>

            {{-- Author and read more button --}}
            <div class="flex items-center justify-end gap-2 flex-nowrap">
                <p class="text-xs font-thin truncate">{{ __('Author') }}: {{ $author }}</p>
                <x-buttons.primary-button class="text-xs min-w-fit text-lime-main" target="login"
                    translation="{{ __('Read More') }}->" />
            </div>
        </div>
    </div>
</a>
