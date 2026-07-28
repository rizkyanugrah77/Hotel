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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js'])
</head>

<body class="bg-gray-100 text-foreground font-inter h-screen overflow-hidden flex relative">

    <livewire:layout.sidebar />
    <div class="flex-1 flex flex-col">
        <livewire:layout.navigation />


        <div class="flex-1 flex flex-col overflow-y-scroll">

            @if (isset($header))
                {{ $header }}
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}

            </main>
        </div>
    </div>
    @livewireScriptConfig
    @stack('scripts')
</body>

</html>
