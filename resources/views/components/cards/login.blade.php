<div {{ $attributes->merge(['class' => 'text-sm font-light text-lime-shadow']) }}>
    <p>{{ __('Already have an account?') }}</p>
    <a class="font-medium hover:underline text-primary-500" href="{{ route('login') }}" wire:navigate>{{ __('Login') }}
    </a>
</div>
