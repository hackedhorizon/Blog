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

<div class="p-10 rounded-lg shadow-lg bg-surface-300">
    <h2 id="edit-article-header" class="mb-6 text-3xl font-bold text-center text-lime-main">
        {{ __('posts.Edit Article') }}
    </h2>

    <x-form wire:submit.prevent="save" class="space-y-6">
        <!-- Author and Title Inputs -->
        <x-input label="{{ __('Author') }}" wire:model="author" readonly class="cursor-not-allowed" />

        <x-input label="{{ __('Title') }}" wire:model="title" class="border-2" />

        <!-- TinyMCE Editor for Content -->
        <x-editor id="editor" label="{{ __('posts.Content') }}" :config="$config" wire:model.defer="body"
            class="w-full h-64 border-2 rounded-lg" />

        <!-- Display Current Categories -->
        <div class="space-y-2">
            <p class="text-lg font-semibold">{{ __('posts.Currently Selected Categories') }}:</p>
            <p class="text-sm italic text-lime-shadow">
                {{ $currentCategories ?: __('No categories selected.') }}</p>
        </div>

        <!-- Select New Categories -->
        <x-choices label="{{ __('posts.Select New Categories') }}" wire:model="newCategories" :options="$categories"
            option-label="label" option-value="value" multiple compact allow-all class="border-2" />

        <!-- Featured Toggle -->
        <x-toggle label="{{ __('Featured') }}" wire:model="featured" />

        <!-- Form Actions -->
        <x-slot:actions>
            <div class="flex items-center justify-between mt-8 space-x-4">
                <x-button wire:click="close" class="px-6 py-2 btn btn-outline btn-error">
                    {{ __('Close') }}
                </x-button>

                <x-button label="{{ __('Save') }}"
                    class="px-6 py-2 font-semibold text-black bg-lime-main hover:bg-lime-600 hover:text-white"
                    type="submit" spinner="save" />
            </div>
        </x-slot:actions>
    </x-form>
</div>

@script
    <script>
        $wire.on('removeTinyMCE', () => tinymce.remove());
    </script>
@endscript
