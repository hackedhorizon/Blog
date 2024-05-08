<a {{ $attributes->merge(['class' => 'text-sm font-medium hover:underline text-primary-500']) }}
    href="{{ route('password.request') }}" wire:navigate='true'>{{ __('Forgot your password?') }}
</a>
