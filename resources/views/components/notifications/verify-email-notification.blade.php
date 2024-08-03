@auth
    @if (config('services.should_verify_email') && !Auth::user()->hasVerifiedEmail())
        <div x-data="{ open: true }" x-show="open" class="relative p-4 border-l-4 border-lime-main bg-surface-300">
            <div class="flex items-center justify-between">
                <span class="flex flex-row gap-1 text-lg font-bold">
                    @svg('eos-email', ['class' => 'w-5'])
                    {{ __('register.verify_your_email') }}
                </span>
                <button @click="open = false" class="text-xl">&times;</button>
            </div>
            <div class="mt-2 text-sm">
                {{ __('register.please_verify_your_email_address_by_navigating_to_the') }}
                <a href="{{ route('verification.notice') }}" class="underline" wire:navigate>
                    {{ __('register.verification_page') }}.
                </a>
            </div>
        </div>
    @endif
@endauth
