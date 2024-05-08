<div class="max-w-sm mx-auto overflow-hidden transition-all duration-300 "
    :style="{ 'max-height': searchOpen ? '500px' : '0' }">
    <div class="px-4 pt-2 pb-3">
        <x-navigation.search-input />
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-lime-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            </svg>
        </div>
    </div>
</div>
