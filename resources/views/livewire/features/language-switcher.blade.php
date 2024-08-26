<div class="flex flex-col w-screen text-center">
    <label for="language">{{ __('Language') }}</label>
    <select id='language' wire:model.live='selectedLanguage'
        class="w-full max-w-xs mx-auto select select-info bg-surface-300">
        @foreach ($languages as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
