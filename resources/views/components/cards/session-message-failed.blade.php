@session('message_failed')
    <div class="absolute left-0 right-0 z-30 flex flex-row items-center justify-center mt-24 space-x-2 text-red-500">
        <span class="w-5 h-5">{{ svg('gmdi-info') }}</span>
        <p>{{ $value }}</p>
    </div>
@endsession
