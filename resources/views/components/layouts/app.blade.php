<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @vite('resources/js/app.js')
</head>

<body x-data="{ open: false, searchOpen: false }"
    class="flex flex-col min-h-screen font-semibold tracking-widest bg-surface-100 text-primary-500 font-secondary">

    {{-- Email notification --}}
    <x-notifications.verify-email-notification />

    {{-- Navbar --}}
    <x-navigation.navbar />

    {{-- Session messages --}}
    <x-cards.session-message-success />

    <x-cards.session-message-failed />

    {{-- Blurred overlay --}}
    <div x-bind:class="{ 'z-40 filter bg-black/50 blur-sm top-0 left-0 w-full h-full pointer-events-none ': open || searchOpen }"
        class="transition-all duration-700 ease-in-out">

        {{-- Main content --}}
        <main class="flex items-center justify-center min-h-screen md:pt-16">
            {{ $slot }}
        </main>

        <x-navigation.footer />

    </div>

</body>

</html>
