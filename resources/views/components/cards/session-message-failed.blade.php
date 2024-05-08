@session('message_failed')
    <div class="z-30 flex flex-row items-center mx-auto mt-20 space-x-2 text-red-500">
        <span class="w-5 h-5">{{ svg('gmdi-info') }}</span>
        <p>{{ $value }}</p>
    </div>
@endsession
