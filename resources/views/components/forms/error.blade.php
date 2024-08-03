<div {{ $attributes->merge(['class' => 'text-red-500 text-base']) }}>
    @error($attribute)
        @if ($attribute === 'login.throttled' || $attribute === 'register.throttled')
            @php
                // Define a regular expression pattern to match any sequence of digits
                $pattern = '/(\d+)/';
                // Extract the number of seconds from the error message using the regular expression
                preg_match($pattern, $message, $matches);
                $seconds = isset($matches[1]) ? $matches[1] : 0;
            @endphp

            <span x-data="{ count: {{ $seconds }}, showMessage: true }" x-init="() => {
                setInterval(() => {
                    if (count > 0) {
                        count--;
                    } else {
                        showMessage = false;
                    }
                }, 1000);
            }" x-show="showMessage">
                <!-- Output the error message with the dynamic countdown timer -->
                <p>{!! preg_replace($pattern, '<span id="counterElement" x-text="count"></span>', $message, 1) !!}</p>
            @else
                <p>{{ $message }}</p>
        @endif
    @enderror
</div>
