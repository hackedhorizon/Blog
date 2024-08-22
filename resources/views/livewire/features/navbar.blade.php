<nav class="z-10 w-full px-4">

    {{-- Mobile Navigation --}}
    <div class="text-sm h-14 btm-nav md:hidden bg-surface-400">
        @php
            $routes = [
                'home' => ['icon' => 'heroicon-o-home', 'label' => __('Home')],
                'posts' => ['icon' => 'eos-explore-o', 'label' => __('Articles')],
            ];
            if (auth()->check()) {
                $routes['profile'] = ['icon' => 'heroicon-o-user', 'label' => __('Account')];
                $routes['auth.settings'] = ['icon' => 'heroicon-c-cog-8-tooth', 'label' => __('Settings')];
                $routes['logout'] = ['icon' => 'heroicon-o-arrow-right', 'label' => __('Logout')];
            } else {
                $routes['login'] = ['icon' => 'heroicon-o-user', 'label' => __('Login')];
                $routes['guest.settings'] = ['icon' => 'heroicon-c-cog-8-tooth', 'label' => __('Settings')];
            }
        @endphp

        @foreach ($routes as $route => $data)
            <a href="{{ route($route) }}"
                class="{{ request()->routeIs($route) ? 'active border-t-2 bg-surface-200 text-lime-main' : '' }}"
                wire:navigate>
                @svg($data['icon'], ['class' => 'w-5 h-5'])
                <span class="btm-nav-label">{{ $data['label'] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Desktop Navigation --}}
    <div class="max-w-screen-xl mx-auto my-2 border-b md:block md:px-4 lg:px-8 border-base-300">
        <div class="flex items-center justify-between md:flex-col lg:flex-row min-h-20">

            {{-- Logo --}}
            <div class="flex-1">
                <x-navigation.logo />
            </div>

            {{-- Navigation Links --}}
            <div class="flex items-center md:gap-4">

                {{--  Articles page  --}}
                <a wire:key='articles' wire:navigate type="button"
                    class="hidden normal-case btn btn-ghost btn-md md:flex" href="{{ route('posts') }}">
                    <span class="block">
                        @svg('eos-explore-o', ['class' => 'w-5 h-5'])
                    </span>
                    <span class="hidden md:block">
                        {{ __('Articles') }}
                    </span>
                </a>

                {{-- Authenticated user: will see articles, notifications, profile dropdown and settings --}}
                @auth
                    {{-- Notifications --}}
                    <livewire:features.notification />

                    {{-- Profile Dropdown --}}
                    <div class="hidden md:block">
                        <x-dropdown>
                            <x-slot:trigger class="normal-case btn btn-ghost btn-md place-self-center">
                                <x-heroicon-o-user class="w-5 h-5 bg-transparent hover:bg-transparent" />
                                <span class="hidden md:block">{{ __('Account') }}</span>
                            </x-slot:trigger>
                            <x-menu-item title="{{ __('Settings') }}" link="{{ route('auth.settings') }}"
                                icon="o-cog-8-tooth" />
                            <x-menu-item title="{{ __('Logout') }}" link="{{ route('logout') }}" icon="o-arrow-right" />
                        </x-dropdown>
                    </div>
                @else
                    {{-- Guest user: will see articles, login and settings --}}
                    <x-button label="{{ __('Login') }}" icon="o-user" link="{{ route('login') }}"
                        class="hidden btn-ghost btn-md md:flex" responsive />

                    <x-button label="{{ __('Settings') }}" link="{{ route('guest.settings') }}" icon="o-cog-8-tooth"
                        class="hidden btn-ghost btn-md md:flex" responsive />
                @endauth
            </div>
        </div>
    </div>
</nav>
