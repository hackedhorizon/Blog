<div x-data="{ open: false }" @click.away="open = false" class="relative flex" name="language" id="language">

    {{-- Desktop button to toggle the language dropdown --}}
    <button @click="open = !open"
        class="items-center justify-center hidden w-auto px-3 py-2 space-x-2 transition-colors duration-200 bg-transparent shadow-none md:flex text-white-primary hover:text-primary-100">

        {{-- Display selected language icon --}}
        <img src="{{ asset("vendor/blade-flags/language-$selectedLanguage.svg") }}" class="h-auto w-7"
            alt="{{ $selectedLanguage }}" />

        {{-- Display selected language key --}}
        <span>{{ $selectedLanguage }}</span>

        {{-- Arrow icon to indicate dropdown state --}}
        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200" fill="none"
            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    {{-- Desktop Language dropdown menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95" @click.away="open = false"
        class="absolute z-10 hidden w-32 py-2 mx-auto rounded-lg shadow-lg top-10 md:flex md:-translate-x-1/2 md:left-1/2 z-1 bg-surface-300">

        {{-- List of available languages --}}
        <ul class="p-2 space-y-2">

            {{-- Loop through languages --}}
            @foreach ($languages as $key => $language)
                <li class="flex items-center px-2 transition-colors duration-300 cursor-pointer hover:text-primary-100"
                    wire:click="$set('selectedLanguage', '{{ $key }}')">

                    {{-- Display language icon --}}
                    <img src="{{ asset("vendor/blade-flags/language-$key.svg") }}" class="h-auto w-7"
                        alt="{{ $selectedLanguage }}" />

                    {{-- Display language --}}
                    <div class="block w-full px-4 py-2 text-sm">

                        {{-- Display language name --}}
                        {{ $language }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Mobile dropdown --}}
    <div class="dropdown dropdown-top ">
        <div tabindex="0" role="button" @click="open = !open"
            class="flex flex-col items-center justify-center w-full h-full gap-1 md:hidden">
            {{-- Display language selector icon --}}
            <div class="w-5 h-5">
                {{ svg('gmdi-language') }}
            </div>
            <span>
                {{ __('Language') }}
            </span>
        </div>

        <ul x-show="open" tabindex="0"
            class="dropdown-content z-[1] menu p-2 shadow bg-surface-300 rounded-box w-32 -translate-x-1/2 left-1/2 mb-5">
            @foreach ($languages as $key => $language)
                <li class="flex flex-row items-center py-3 duration-200 active:bg-transparent translate-colors"
                    wire:click="$set('selectedLanguage', '{{ $key }}')">

                    {{-- Display language icon --}}
                    <div class="p-0 w-7">
                        <img src="{{ asset("vendor/blade-flags/language-$key.svg") }}" width="28px"
                            alt="{{ $selectedLanguage }}" />
                    </div>

                    {{-- Display language --}}
                    <a class="flex justify-end p-0 mx-auto text-sm w-fit hover:bg-transparent">
                        {{-- Display language name --}}
                        {{ $language }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
