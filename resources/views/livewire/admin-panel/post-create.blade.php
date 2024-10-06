@php
    $config = [
        'plugins' =>
            'autoresize advlist link image lists anchor autolink charmap codesample emoticons media searchreplace table visualblocks wordcount',
        'statusbar' => true,
        'toolbar' =>
            'undo redo | quickimage quicktable | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        'quickbars_selection_toolbar' => 'bold italic link',
        'menubar' => 'file edit view',
        'resize' => true,
        'skin' => 'oxide-dark',
        'content_css' => 'dark',
    ];
@endphp

<div class="w-full min-h-screen p-6 mx-auto my-4 rounded-lg shadow-md md:min-h-fit bg-surface-200">
    <h2 class="mb-5 text-2xl font-semibold text-center">{{ __('posts.Create Article') }}</h2>

    <x-form wire:submit.prevent="createPost" class="space-y-6">
        <div class="space-y-4">
            <x-input label="{{ __('posts.Title') }}" wire:model.blur="title" placeholder="{{ __('posts.Title') }}"
                clearable class="w-full" />
            <x-editor label="{{ __('posts.Content') }}" :config="$config" wire:model.defer="content"
                class="w-full h-64 border rounded-lg" />
        </div>

        <div class="grid grid-cols-1 gap-6 ">
            <x-toggle label="{{ __('Featured') }}" wire:model.live="featured" />
            <x-toggle label="{{ __('posts.Auto translate') }}" wire:model.live="autoTranslate" />

            @if (!$autoTranslate)
                <x-choices label="{{ __('posts.Select languages for translation') }}" wire:model="selectedLanguages"
                    :options="$languages" option-label="label" multiple compact allow-all option-value="value" multiple />
            @endif

            <x-toggle label="{{ __('posts.Publish now') }}" wire:model.live="published" />

            @if (!$published)
                @php
                    $config1 = ['dateFormat' => 'Y-m-d H:i', 'enableTime' => true, 'time_24hr' => true];
                @endphp
                <x-datepicker label="{{ __('posts.Publish at a specific time') }}" wire:model="publicationDate"
                    icon="o-calendar" :config="$config1" />
            @endif

            <x-choices label="{{ __('posts.Select categories') }}" wire:model="selectedCategories" :options="$categories"
                option-label="label" option-value="value" multiple compact allow-all />
        </div>

        <div class="flex justify-end">
            <x-button class="mt-5 btn-success bg-surface-300 text-lime-main hover:bg-surface-500 w-fit" type="submit"
                spinner="createPost" label="{{ __('Create') }}" />
        </div>
    </x-form>
</div>
