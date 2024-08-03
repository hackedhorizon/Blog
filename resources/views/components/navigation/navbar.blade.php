<div @click.away="open = false; searchOpen = false">

    <nav class="z-50 max-w-screen-xl mx-auto" @click.away="open = false; searchOpen = false">

        <div class="px-4 mx-auto my-2 md:px-4 lg:px-8">

            <div
                class="flex items-center justify-between ml-auto md:flex-col md:justify-center lg:flex-row lg:justify-between min-h-20">

                <div class="md:py-2 lg:py-0">
                    {{-- Logo --}}
                    <x-navigation.logo />

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
