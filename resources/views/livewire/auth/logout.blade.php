<div class="transition-all duration-200 hover:text-primary-100" wire:click="logout">
    <div class="hidden md:flex">
        <x-buttons.primary-button click="logout" translation="{{ __('Logout') }}" />
    </div>

    <div class="md:hidden">
        <button
            class="bg-surface-300 flex flex-col gap-1 items-center {{ request()->routeIs('profile') || request()->routeIs('register') ? 'active border-primary-100' : '' }}">
            <div class="w-5 h-5">
                {{ svg('gmdi-logout') }}
            </div>
            <span>
                {{ __('Logout') }}
            </span>
        </button>
    </div>
</div>
