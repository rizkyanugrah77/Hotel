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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600|inter:400,500,600|poppins:500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js'])

    @livewireStyles
</head>

<body class="font-inter text-gray-900 antialiased">
    <div class="relative min-h-screen flex items-center justify-center px-4 py-8 sm:py-12 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('dist/resources/assets/images/hero.png') }}" alt="Sitio Tio Resort"
                class="w-full h-full object-cover scale-105" loading="eager" />
            <div class="absolute inset-0 bg-gradient-hero"></div>
        </div>

        <!-- Floating Batak Pattern & Ambient Glow -->
        <div class="absolute inset-0 batak-pattern opacity-20"></div>
        <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-primary/25 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-accent/20 blur-3xl"></div>

        <!-- Content -->
        <div class="relative z-10 w-full max-w-md">
            <!-- Branding -->
            <div class="flex flex-row justify-center items-center gap-2 mb-6">
                <a href="/" wire:navigate class="group flex flex-row justify-center items-center gap-2.5">
                    <x-application-logo class="!w-12 !h-12" />
                </a>
            </div>

            <!-- Card -->
            <div class="relative overflow-hidden rounded-3xl bg-white/85 backdrop-blur-xl border border-white/60 shadow-2xl ring-1 ring-black/5 p-6 sm:p-8 md:p-9">
                <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-primary via-accent to-primary"></div>
                {{ $slot }}
            </div>
        </div>
    </div>
    @livewireScriptConfig
</body>

</html>
