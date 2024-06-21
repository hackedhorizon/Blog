<div {{ $attributes->merge(['class' => 'text-base font-light text-lime-shadow']) }}>
    <p>{{ __('Dont have an account yet?') }}</p>
    <a class="font-medium hover:underline text-primary-500" href="{{ route('register') }}"
        wire:navigate>{{ __('Register') }}
    </a>
</div>
