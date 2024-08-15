<div wire:poll.3s>
    <x-dropdown>
        <x-slot:trigger>
            <x-button icon="o-bell" class="btn-circle btn-ghost">
                <x-badge value="{{ $unreadNotificationsCount }}" class="absolute badge-info -right-2 -top-2" />
            </x-button>
        </x-slot:trigger>

        @forelse ($notifications as $notification)
            <x-menu-item wire:click="markAsRead('{{ $notification->id }}')">
                <div class="{{ $notification->read_at ? 'text-lime-shadow' : 'text-lime-main' }}">
                    <strong>{{ $notification->data['title'] }}</strong>
                    <p>{{ $notification->data['message'] }}</p>
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
