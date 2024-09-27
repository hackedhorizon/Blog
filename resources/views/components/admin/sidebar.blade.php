{{-- Admin Sidenav --}}

<x-menu activate-by-route active-bg-color="bg-surface-500" class="w-64 border border-solid bg-surface-300">

    <div class="px-4 pb-4 text-2xl text-lime-main">{{ __('Dashboard') }}</div>

    <x-menu-item title="{{ __('Statistics') }}" link="{{ route('admin.dashboard') }}" route="admin.dashboard" />

    <x-menu-sub title="{{ __('Articles') }}">
        <x-menu-item title="{{ __('Create') }}" icon="" link="{{ route('admin.dashboard.posts.create') }}"
            route="admin.dashboard.posts.create" />
        <x-menu-item title="{{ __('Edit') }}" link="{{ route('admin.dashboard.posts.table') }}"
            route="admin.dashboard.posts.table" />
    </x-menu-sub>

</x-menu>
