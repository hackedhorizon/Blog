@props([
    'class_ul' => '',
    'class_href' => '',
])

<ul {{ $attributes->merge(['class' => '' . $class_ul]) }}>

    @auth
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

        <li>
            <livewire:features.notification />
        </li>
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
