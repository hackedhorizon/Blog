<div class="relative p-6 my-4 mb-10 rounded-lg shadow-md bg-surface-200" role="region"
    aria-labelledby="edit-article-header">
    {{-- Placeholder for the Page Header --}}
    <h2 id="edit-article-header" class="mb-5 text-2xl font-semibold text-center">
        <div class="w-40 h-8 mx-auto bg-gray-300 rounded animate-pulse"></div>
    </h2>

    <div class="flex items-center justify-between py-4">
        <!-- Placeholder for Search Input -->
        <div class="flex-grow">
            <div class="w-full h-10 bg-gray-300 rounded animate-pulse"></div>
        </div>

        <!-- Placeholder for Pagination Size Selector -->
        <div class="w-32 h-10 ml-2 bg-gray-300 rounded animate-pulse"></div>
    </div>

    <!-- Placeholder for Current Page Info -->
    <div class="text-sm text-gray-600">
        <div class="w-32 h-6 bg-gray-300 rounded animate-pulse"></div>
    </div>

    {{-- Placeholder for Posts table --}}
    <div class="mt-4">
        @for ($i = 0; $i < 5; $i++)
            <div class="flex items-center justify-between py-2">
                <div class="w-40 h-6 bg-gray-300 rounded animate-pulse"></div> <!-- Placeholder for Username -->
                <div class="h-6 bg-gray-300 rounded animate-pulse w-96"></div> <!-- Placeholder for Title -->
                <div class="w-32 h-6 bg-gray-300 rounded animate-pulse"></div> <!-- Placeholder for Created At -->
            </div>
        @endfor
    </div>

    <!-- Placeholder for Action Buttons -->
    <div class="flex gap-2 mt-4">
        @for ($i = 0; $i < 3; $i++)
            <div class="w-8 h-8 bg-gray-300 rounded-full animate-pulse"></div> <!-- Placeholder for Buttons -->
        @endfor
    </div>

    <!-- Placeholder for Pagination Links -->
    <div class="py-4">
        <div class="w-full h-8 bg-gray-300 rounded animate-pulse"></div>
    </div>
</div>
