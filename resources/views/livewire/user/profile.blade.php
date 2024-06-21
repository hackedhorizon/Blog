@php
    $formFields = [
        'name' => 50,
        'username' => 30,
        'email' => 50,
        'password' => 300,
    ];
@endphp

<x-cards.form-card-container>

    {{-- Form title --}}
    <x-cards.form-card-title :list="[__('Account data')]" />

    <form wire:submit="updateProfileInformation" class="space-y-4 card-body md:space-y-6">

        {{-- Form fields --}}
        @foreach ($formFields as $field => $maxlength)
            @php
                $translationKey = 'validation.attributes.' . $field;
                $type = $field === 'password' ? 'password' : 'text';
            @endphp

            <label for="{{ $field }}" class="label">
                <span class="leading-8 text-primary-500">{{ ucfirst(__($translationKey)) }}</span>
            </label>

            <x-forms.input :id="$field" :type="$type" :maxlength="$maxlength" :placeholder="ucfirst(__($translationKey))" :variable="$field"
                :label="ucfirst(__($translationKey))" class="w-full input input-bordered placeholder-lime-shadow/50 bg-surface-300" />
        @endforeach

        {{-- Update or delete profile button --}}
        <div class="flex flex-row flex-wrap items-center justify-between gap-5 mt-6 form-control">
            <x-buttons.primary-button class="btn btn-neutral text-primary-500 bg-surface-300 hover:bg-surface-400"
                translation="{{ __('Update') }}" />

            <button wire:click.prevent="deleteUser" class="btn btn-error"
                wire:confirm="{{ __('profile.are_you_sure_you_want_to_delete_your_account') }}">
                {{ __('profile.delete_user_account') }}
            </button>
        </div>

        <x-forms.error attribute='update' />
    </form>

</x-cards.form-card-container>
