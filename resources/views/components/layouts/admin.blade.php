<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @vite('resources/js/app.js', ['defer' => true])

    <script src="{{ asset('build/tinymce/tinymce.min.js') }}"></script>

    {{-- Flatpickr  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body x-data="{ open: false, searchOpen: false }"
    class="flex flex-col min-h-screen overflow-x-hidden transition-all duration-300 bg-center bg-default md:text-xl lg:text-2xl text-primary-500">

    {{-- Toast messages --}}
    <x-toast position="toast-top toast-center" />

    {{-- Email notification --}}
    <x-notifications.verify-email-notification />

    {{-- Default navigation --}}
    @livewire('features.navbar')

    {{-- Admin dashboard mobile navigation --}}
    <x-admin.mobile-navbar />

    {{-- Modal component --}}
    @livewire('wire-elements-modal')

    {{-- Main content --}}
    <main class="w-full text-lime-main">
        <div class="max-w-screen-xl mx-auto drawer lg:drawer-open">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="flex flex-col drawer-content">
                {{-- Main content --}}
                {{ $slot }}
            </div>

            <div class="z-10 drawer-side">
                <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
                <ul class="min-h-full p-4 menu bg-surface-100 lg:bg-transparent text-base-content w-80">
                    {{-- Sidebar content --}}
                    <x-admin.sidebar />
                </ul>
            </div>
        </div>
    </main>
</body>

</html>
