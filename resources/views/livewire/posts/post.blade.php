<div wire:transition>
    <x-card title="Nice things">
        I am using slots here.

        <x-slot:figure>
            <img src="https://picsum.photos/500/200" />
        </x-slot:figure>
        <x-slot:menu>
            <x-button icon="o-share" class="btn-circle btn-sm" />
            <x-icon name="o-heart" class="cursor-pointer" />
        </x-slot:menu>
        <x-slot:actions>
            <x-button label="Ok" class="btn-primary" />
        </x-slot:actions>
    </x-card>
</div>
