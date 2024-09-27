<ul class="flex flex-row flex-wrap justify-center gap-2 p-4 lg:bg-transparent text-base-content lg:hidden">
    <x-dropdown label="Post manager" class="btn btn-outline btn-sm">
        <x-menu-item title="Create Post" link="{{ route('admin.dashboard.posts.create') }}" />
        <x-menu-item title="Edit Post" />
        <x-menu-item title="Delete Post" />
    </x-dropdown>
    <x-dropdown label="User manager" class="btn btn-outline btn-sm">
        <x-menu-item title="Create Post" link="{{ route('admin.dashboard.posts.create') }}" />
        <x-menu-item title="Edit Post" />
        <x-menu-item title="Delete Post" />
    </x-dropdown>
    <x-dropdown label="Settings" class="btn btn-outline btn-sm">
        <x-menu-item title="Create Post" link="{{ route('admin.dashboard.posts.create') }}" />
        <x-menu-item title="Edit Post" />
        <x-menu-item title="Delete Post" />
    </x-dropdown>
</ul>
