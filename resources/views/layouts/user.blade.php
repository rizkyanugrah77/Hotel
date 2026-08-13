<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Dashboard — {{ config('app.name') }}</title>
    <meta name="description"
        content="Dashboard tamu Sitio Tio Resort — kelola booking, lihat riwayat, dan cek status check-in Anda.">
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Ctext y='28' font-size='28'%3E🏨%3C/text%3E%3C/svg%3E" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&family=inter:400,500,600,700&family=poppins:400,500,600,700&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js'])
    @livewireStyles

    <style>
        /* Bottom nav safe area for mobile */
        .pb-safe-bottom {
            padding-bottom: calc(5rem + env(safe-area-inset-bottom, 0px));
        }

        /* Smooth entry animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .delay-1 {
            animation-delay: 0.05s;
        }

        .delay-2 {
            animation-delay: 0.1s;
        }

        .delay-3 {
            animation-delay: 0.15s;
        }

        .delay-4 {
            animation-delay: 0.2s;
        }

        .delay-5 {
            animation-delay: 0.25s;
        }

        .delay-6 {
            animation-delay: 0.3s;
        }

        .delay-7 {
            animation-delay: 0.35s;
        }

        /* Hide scrollbar on horizontal scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-foreground font-inter min-h-screen">

    <!-- ===== Top Navbar ===== -->
    <livewire:layout.navigation />

    <!-- ===== Page Content ===== -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-safe-bottom">
        {{ $slot }}
    </main>

    <!-- ===== Mobile Bottom Navigation ===== -->

    @livewireScriptConfig
    @stack('scripts')
</body>

</html>
