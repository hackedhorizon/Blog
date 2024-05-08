@php
    $formFields = [
        'name' => 50,
        'username' => 30,
        'email' => 50,
        'password' => 300,
    ];
@endphp
<section class="mt-16 md:mt-0 hero">
    <div class="w-full max-w-screen-sm px-10 hero-content">
        <div class="w-full card bg-surface-200">
            {{-- Card title --}}
            <h1 class="pt-4 text-xl font-bold leading-tight tracking-tight text-center md:text-2xl">
                {{ __('Account data') }}
            </h1>

            <form wire:submit="updateProfileInformation" class="space-y-4 card-body md:space-y-6">

                @foreach ($formFields as $field => $maxlength)
                    @php
                        $translationKey = 'validation.attributes.' . $field;
                        $type = $field === 'password' ? 'password' : 'text';
                    @endphp

                    <label for="{{ $field }}" class="label">
                        <span class="label-text text-primary-500">{{ ucfirst(__($translationKey)) }}</span>
                    </label>

                    <x-forms.input :id="$field" :type="$type" :maxlength="$maxlength" :placeholder="ucfirst(__($translationKey))"
                        :variable="$field" :label="ucfirst(__($translationKey))"
                        class="w-full input input-bordered placeholder-lime-shadow/50 bg-surface-300" />
                @endforeach

                <div class="flex flex-row flex-wrap items-center justify-between gap-5 mt-6 form-control">
                    <x-buttons.primary-button
                        class="btn btn-neutral text-primary-500 bg-surface-300 hover:bg-surface-400"
                        translation="{{ __('Update') }}" />

                    <button wire:click.prevent="deleteUser" class="btn btn-error"
                        wire:confirm="{{ __('profile.are_you_sure_you_want_to_delete_your_account') }}">
                        {{ __('profile.delete_user_account') }}
                    </button>
                </div>

                <x-forms.error attribute='update' />
            </form>

        </div>
    </div>
</section>
