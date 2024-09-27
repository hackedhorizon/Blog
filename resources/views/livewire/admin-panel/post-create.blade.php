@php
    $config = [
        'plugins' =>
            'autoresize advlist link image lists anchor autolink charmap codesample emoticons media searchreplace table visualblocks wordcount',
        'statusbar' => true,
        'toolbar' =>
            'undo redo | quickimage quicktable undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        'quickbars_selection_toolbar' => 'bold italic link',
        'menubar' => 'file edit view',
        'resize' => true,
    ];
@endphp

<div>
    <h2 class="py-5 text-xl font-semibold">{{ __('posts.Create Article') }}</h2>

    <x-form wire:submit.prevent="createPost" class="grid gap-6 p-6 rounded-sm bg-surface-300 lg:grid-cols-2">
        <div class="flex flex-col gap-5">
            <x-input label="{{ __('posts.Title') }}" wire:model.blur="title" placeholder="{{ __('posts.Title') }}"
                clearable class="w-full" />
            <x-editor label="{{ __('posts.Content') }}" :config="$config" wire:model.defer="content"
                class="w-full h-64" />
        </div>

        <div class="flex flex-col gap-5">
            <x-toggle label="{{ __('Featured') }}" wire:model.live="featured" right />
            <x-toggle label="{{ __('posts.Auto translate') }}" wire:model.live="autoTranslate" right />

            @if (!$autoTranslate)
                <x-choices label="{{ __('posts.Select languages for translation') }}" wire:model="selectedLanguages"
                    :options="$languages" option-label="label" option-value="value" multiple />
            @endif

            <x-toggle label="{{ __('posts.Publish now') }}" wire:model.live="published" right />

            @if (!$published)
                @php
                    $config1 = ['dateFormat' => 'Y-m-d H:i', 'enableTime' => 'true', 'time_24hr' => 'true'];
                @endphp
                <x-datepicker label="{{ __('posts.Publish at a specific time') }}" wire:model="publicationDate"
                    icon="o-calendar" :config="$config1" />
            @endif

            <x-choices label="{{ __('posts.Select categories') }}" wire:model="selectedCategories" :options="$categories"
                option-label="label" option-value="value" multiple />
        </div>

        <div class="flex justify-end col-span-full">
            <x-button class="mt-5 btn-success bg-surface-300 text-lime-main hover:bg-surface-500 w-fit" type="submit"
                spinner="createPost" label="{{ __('Create') }}" />
        </div>
    </x-form>
</div>
