<button {{ $attributes->merge(['class' => '']) }} wire:loading.attr="disabled"
    @if (isset($target)) wire:target='{{ $target }}' @endif
    @if (isset($click)) wire:click="{{ $click }}" @endif>

    <span wire:loading.remove wire:target="login, register">{{ $translation }}</span>
    <span wire:loading wire:target="login, register" class="loading loading-spinner loading-md"></span>
</button>
