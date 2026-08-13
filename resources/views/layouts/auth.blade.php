<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Ctext y='28' font-size='28'%3E🏨%3C/text%3E%3C/svg%3E" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js'])

    @livewireStyles
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="relative min-h-screen flex items-center justify-center px-4 py-8 sm:py-10 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('dist/resources/assets/images/hero.png') }}" alt="Sitio Tio Resort"
                class="w-full h-full object-cover" loading="eager" />
            <div class="absolute inset-0 bg-gradient-hero"></div>
        </div>

        <!-- Floating Batak Pattern -->
        <div class="absolute inset-0 batak-pattern opacity-20"></div>

        <!-- Content -->
        <div class="relative z-10 w-full max-w-md">
            <!-- Branding -->
            <div class="flex flex-row justify-center items-center gap-2 mb-6">
                <a href="/" wire:navigate class="group flex flex-row justify-center items-center gap-2">
                    <x-application-logo class="!w-12 !h-12" />
                </a>

            </div>

            <!-- Card -->
            <div class="glass rounded-3xl shadow-soft-xl p-6 sm:p-8 md:p-10">
                {{ $slot }}
            </div>
        </div>
    </div>
    @livewireScriptConfig
</body>

</html>
