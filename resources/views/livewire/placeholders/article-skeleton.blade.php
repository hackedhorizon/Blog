<div class="flex flex-col max-w-screen-xl gap-10 p-10 mx-auto">
    <h1 class="text-3xl">
        {{ __($param) }}
    </h1>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
        @for ($i = 0; $i < 3; $i++)
            <div class="flex flex-col gap-4 w-52">
                <div class="w-full h-full skeleton"></div>
                <div class="h-4 skeleton w-28"></div>
                <div class="w-full h-4 skeleton"></div>
                <div class="w-full h-4 skeleton"></div>
            </div>
        @endfor
    </div>
</div>
