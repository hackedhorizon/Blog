<div class="z-50 btm-nav bg-surface-300 md:hidden">
    {{-- User logged in --}}
    @auth

        <a href="{{ route('home') }}"
            class=" border-0  {{ request()->routeIs('home') ? 'active bg-surface-200 text-lime-main' : '' }}" wire:navigate>
            <div class="w-5 h-5">
                {{ svg('gmdi-home') }}
            </div>
            <span>
                {{ __('Home') }}
            </span>
        </a>

        <a href="{{ route('profile') }}"
            class=" border-0 {{ request()->routeIs('profile') || request()->routeIs('register') ? 'active bg-surface-200 text-lime-main' : '' }}"
            wire:navigate>
            <div class="w-5 h-5">
                {{ svg('gmdi-account-circle') }}
            </div>
            <span>
                {{ __('Account') }}
            </span>
        </a>

        <x-localization.language-switcher />

        @livewire('auth.logout')

        {{-- User logged out --}}
    @else
        <a href="{{ route('home') }}"
            class=" border-0  {{ request()->routeIs('home') ? 'active bg-surface-200 text-lime-main' : '' }}" wire:navigate>
            <div class="w-5 h-5">
                {{ svg('gmdi-home') }}
            </div>
            <span>
                {{ __('Home') }}
            </span>
        </a>

        <a href="{{ route('login') }}"
            class=" border-0  {{ request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') ? 'active bg-surface-200 text-lime-main' : '' }}"
            wire:navigate>

            <div class="w-5 h-5">
                {{ svg('gmdi-login') }}
            </div>
            <span>
                {{ __('Login') }}
            </span>
        </a>

        <x-localization.language-switcher />

    @endauth

</div>
