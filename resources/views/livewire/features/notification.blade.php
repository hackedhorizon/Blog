<div wire:poll.3s>
    <x-dropdown>

        {{-- Notification bell and text --}}
        <x-slot:trigger class="normal-case btn btn-ghost btn-md place-self-center">
            <span class="block bg-transparent hover:bg-transparent">
                <x-heroicon-o-bell class="w-5 h-5" />
                @if ($unreadNotificationsCount > 0)
                    <x-badge value="{{ $unreadNotificationsCount }}" class="absolute badge-info -right-2 -top-2" />
                @endif
            </span>
            <span class="hidden md:block">{{ __('notifications.info.title') }}</span>
        </x-slot:trigger>

        {{-- Dropdown notifications --}}
        @forelse ($notifications as $notification)
            <x-menu-item wire:click="markAsRead('{{ $notification->id }}')">
                <div class="{{ $notification->read_at ? 'text-lime-shadow' : 'text-lime-main' }} max-w-72">
                    <strong class="block text-pretty">{{ $notification->data['title'] }}</strong>
                    <p class="text-pretty">{{ $notification->data['message'] }}</p>
                </div>
                <x-button wire:click.stop="deleteNotification('{{ $notification->id }}')"
                    class="absolute p-0 px-2 bg-transparent outline-none btn-xs hover:bg-red-600 hover:text-black top-1 right-1">
                    <x-heroicon-o-x-mark class="w-3 h-3" />
                </x-button>
            </x-menu-item>
        @empty
            <x-menu-item>
                <div class="text-center">
                    {{ __('notifications.info.no_notifications_available') }}
                </div>
            </x-menu-item>
        @endforelse

    </x-dropdown>
</div>
