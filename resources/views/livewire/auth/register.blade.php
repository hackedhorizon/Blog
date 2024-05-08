<section class="mt-16 md:mt-0 hero">
    @php
        $formFields = [
            'name' => 50,
            'username' => 30,
            'email' => 50,
            'password' => 300,
        ];
        $recaptchaEnabled = config('services.should_have_recaptcha');
        $siteKey = config('services.google_captcha.site_key');
    @endphp
    <div class="w-full max-w-screen-sm px-10 hero-content">
        <div class="w-full card bg-surface-200">

            {{-- Card title --}}
            <h1 class="pt-4 text-xl font-bold leading-tight tracking-tight text-center md:text-2xl">
                <p>{{ __('Dont have an account yet?') }}</p>
                <p>{{ __('register.create an account') }}</p>
            </h1>

            {{-- Register form --}}
            <form wire:submit="register" class="space-y-4 card-body md:space-y-6">

                {{-- Loop through form fields to generate input components --}}
                @foreach ($formFields as $field => $maxlength)
                    {{-- Construct the translation key --}}
                    @php
                        $translationKey = 'validation.attributes.' . $field;
                    @endphp

                    <div class="form-control">
                        <label for="{{ $field }}" class="label">
                            <span class="label-text text-primary-500">{{ ucfirst(__($translationKey)) }}</span>
                        </label>
                        <x-forms.input id="{{ $field }}" name="{{ $field }}"
                            type="{{ $field === 'password' ? 'password' : 'text' }}" maxlength="{{ $maxlength }}"
                            placeholder="{{ ucfirst(__($translationKey)) }}" variable="{{ $field }}"
                            class="w-full input input-bordered placeholder-lime-shadow/50 bg-surface-300" />
                    </div>
                @endforeach

                {{-- Submit button --}}
                <div class="mt-6 form-control" wire:ignore>
                    <x-buttons.primary-button target="register" translation="{{ __('Register') }}"
                        class="btn btn-neutral text-primary-500 bg-surface-300 hover:bg-surface-400 {{ $recaptchaEnabled ? 'g-recaptcha' : '' }}"
                        data-sitekey="{{ $siteKey }}" data-callback='handle' data-action='register' />
                </div>

                {{-- Recaptcha section --}}
                @if ($recaptchaEnabled)
                    {{-- Recaptcha information --}}
                    <x-forms.recaptcha />

                    {{-- Recaptcha token error --}}
                    <x-forms.error attribute='recaptcha' />
                @endif

                {{-- Login card with link --}}
                <x-cards.login />

                {{-- Register error message --}}
                <x-forms.error attribute='register' />

            </form>
        </div>
    </div>
</section>

@if ($recaptchaEnabled)
    <script src="https://www.google.com/recaptcha/api.js?render={{ $siteKey }}"></script>
    <script>
        function handle(e) {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ $siteKey }}', {
                    action: 'register'
                }).then(function(token) {
                    @this.set('recaptchaToken', token);
                    @this.register();
                });
            })
        }
    </script>
@endif
