<div @click.away="open = false; searchOpen = false">

    <nav class="fixed top-0 z-50 w-full mx-auto border-b shadow-xl bg-surface-200 border-primary-500"
        @click.away="open = false; searchOpen = false">

        <div class="px-4 mx-auto md:px-6 lg:px-8">

            <div class="flex items-center justify-between h-16 ml-auto">

                <div class="flex flex-row justify-between w-full gap-5 md:w-auto">
                    {{-- Logo --}}
                    <x-navigation.logo />

                    {{-- Search icon button --}}
                    <x-navigation.search-icon />
                </div>

                {{-- Desktop view: menu --}}
                <x-navigation.menu-desktop />

            </div>
        </div>

        {{-- Search bar --}}
        <x-navigation.search-bar />

        {{-- Mobile view: menu --}}
        <x-navigation.menu-mobile />
    </nav>

</div>
