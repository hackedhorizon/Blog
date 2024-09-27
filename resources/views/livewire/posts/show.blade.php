<article class="max-w-4xl p-5 mx-auto text-white bg-gray-900 rounded-lg shadow-lg">
    <div class="relative">
        <img src="https://via.placeholder.com/1200x400" alt="Post Header Image"
            class="object-cover w-full h-64 rounded-lg">
        <div class="absolute inset-0 rounded-lg bg-gradient-to-t from-black via-transparent to-transparent"></div>
        <div class="absolute bottom-5 left-5">
            <h1 class="text-4xl font-bold text-white">{{ $title }}</h1>
        </div>
    </div>

    <div class="mt-5">
        <div class="flex items-center space-x-4">
            <img src="https://via.placeholder.com/100" alt="Author Avatar" class="w-16 h-16 rounded-full">
            <div>
                <p class="text-xl font-semibold">{{ $author }}</p>
                <p class="text-gray-400">{{ $date }}</p>
            </div>
        </div>

        <div class="mt-5 text-lg leading-relaxed">
            <p>{{ $body }}</p>
        </div>

        <div class="mt-5">
            <p class="text-gray-400">Tags: {{ $tags }}</p>
        </div>
    </div>
</article>

{{-- Scroll to the top if user navigated to an article --}}
<script>
    window.addEventListener('livewire:navigated', () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>
