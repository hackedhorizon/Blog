<section class="hero">
    <div class="w-full max-w-screen-sm px-10 hero-content">
        <div class="w-full card bg-surface-200">

            {{-- Card title --}}
            <h1 class="pt-4 text-xl font-bold leading-tight tracking-tight text-center md:text-2xl">
                {{ __('Sign in to your account') }}
            </h1>

            {{-- Livewire properties representing form fields --}}
            @php
                $livewireProperties = ['identifier', 'password'];
            @endphp

            {{-- Login form --}}
            <form wire:submit='login' class="space-y-4 card-body md:space-y-6">

                {{-- Loop through form fields to generate input components --}}
                @foreach ($livewireProperties as $index => $property)
                    {{-- Construct the translation key and determine the input type for the current form field --}}
                    @php
                        $translationKey = 'validation.attributes.' . $property;
                        $inputType = $property === 'password' ? 'password' : 'text';
                    @endphp

                    {{-- Include reusable input component for each form field --}}
                    <div class="form-control">
                        <label for="{{ $property }}" class="label">
                            <span class="label-text text-primary-500">{{ ucfirst(__($translationKey)) }}</span>
                        </label>
                        <x-forms.input id="{{ $property }}" name="{{ $property }}" type="{{ $inputType }}"
                            placeholder="{{ ucfirst(__($translationKey)) }}" variable="{{ $property }}"
                            class="w-full input input-bordered placeholder-lime-shadow/50 bg-surface-300" />
                    </div>
                @endforeach


                <div class="flex flex-wrap items-center justify-between gap-2">
                    {{-- Remember me checkbox --}}
                    <x-forms.remember-me />

                    {{-- Forgot password --}}
                    <x-cards.forgot-password />
                </div>

                {{-- Submit button --}}
                <div class="mt-6 form-control">
                    <x-buttons.primary-button
                        class="btn btn-neutral text-primary-500 bg-surface-300 hover:bg-surface-400" target="login"
                        translation="{{ __('Login') }}" />
                </div>

                {{-- Register card with link --}}
                <x-cards.register />

                {{-- Display login error message if any --}}
                <x-forms.error attribute="login" />
            </form>
        </div>
    </div>
</section>
