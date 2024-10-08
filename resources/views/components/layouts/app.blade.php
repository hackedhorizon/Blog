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
    class="flex flex-col overflow-x-hidden transition-all duration-300 bg-center bg-default md:text-xl lg:text-2xl text-primary-500">

    {{-- Toast messages --}}
    <x-toast position="toast-top toast-center" />

    {{-- Email notification --}}
    <x-notifications.verify-email-notification />

    {{-- Navbar --}}
    @livewire('features.navbar')

    {{-- Main content --}}
    <main class="flex items-center justify-center min-h-[calc(100vh-155px)] md:min-h-[calc(100vh-90px)] text-lime-main">
        {{ $slot }}
    </main>

    <x-navigation.footer />
</body>

</html>
