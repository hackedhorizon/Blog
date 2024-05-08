@props([
    'class_ul' => '',
    'class_href' => '',
])

<ul {{ $attributes->merge(['class' => '' . $class_ul]) }}>

    @auth

        <li>
            <strong>{{ __('register.welcome') }}, {{ Auth::user()->username }}!</strong>
        </li>

        <li>
            <a {{ $attributes->merge(['class' => '' . $class_href]) }} href="{{ route('home') }}"
                wire:navigate>{{ __('Home') }}
            </a>
        </li>

        <li>
            <a {{ $attributes->merge(['class' => '' . $class_href]) }} href="{{ route('profile') }}"
                wire:navigate>{{ __('Account') }}
            </a>

        </li>

        @livewire('auth.logout')
    @else
        <li>
            <a {{ $attributes->merge(['class' => '' . $class_href]) }} href="{{ route('home') }}"
                wire:navigate>{{ __('Home') }}
            </a>
        </li>

        <li>
            <a {{ $attributes->merge(['class' => '' . $class_href]) }} href="{{ route('login') }}"
                wire:navigate>{{ __('Login') }}
            </a>
        </li>

    @endauth

    <li>
        <x-localization.language-switcher />
    </li>

</ul>
