<div x-data="{ sidebarOpen: false }">
    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-40 md:hidden"
        @click="sidebarOpen = false" style="display: none;"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 md:relative md:translate-x-0 h-screen bg-gradient-to-br from-slate-800 via-rose-950 to-rose-900 text-white flex-shrink-0 flex flex-col shadow-2xl md:shadow-none">

        <!-- Toggle Button attached to sidebar -->
        <button type="button" @click="sidebarOpen = !sidebarOpen"
            class="md:hidden absolute  top-56 -right-10 bg-rose-900 text-white p-2 rounded-r-md shadow-md focus:outline-none">
            <!-- Icon when closed (hamburger) -->
            <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <!-- Icon when open (close) -->
            <svg x-show="sidebarOpen" style="display: none;" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="h-16 flex items-center justify-between px-6 border-b border-white/10">
            <span class="font-poppins font-bold tracking-wide">Sitio Tio Admin</span>
        </div>

        <nav class="flex-1 py-6 px-4 space-y-2 overflow-y-auto">

            <a href="{{ route('dashboard') }}" wire:navigate @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                'bg-white/10 text-white' => request()->routeIs('dashboard'),
                'text-white/80 hover:text-white hover:bg-white/5' => !request()->routeIs(
                    'dashboard'),
            ])>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('gallery.manager') }}" wire:navigate @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                'bg-white/10 text-white' => request()->routeIs('gallery.manager'),
                'text-white/80 hover:text-white hover:bg-white/5' => !request()->routeIs(
                    'gallery.manager'),
            ])>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l4.684 4.683a2.25 2.25 0 0 0 3.182 0l3.748-3.748"
                        class="text-white" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.5 5.25a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Z" class="text-white" />
                </svg>
                Gallery
            </a>

            <a href="{{ route('bookings.manager') }}" wire:navigate @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                'bg-white/10 text-white' => request()->routeIs('bookings.manager'),
                'text-white/80 hover:text-white hover:bg-white/5' => !request()->routeIs(
                    'bookings.manager'),
            ])>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 3.75H6a2.25 2.25 0 0 0-2.25 2.25v12A2.25 2.25 0 0 0 6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75h-2.25M8.25 3.75A2.25 2.25 0 0 1 10.5 1.5h3a2.25 2.25 0 0 1 2.25 2.25m-7.5 0a2.25 2.25 0 0 0 2.25 2.25h3a2.25 2.25 0 0 0 2.25-2.25m-6 8.25h6m-6 3h6" />
                </svg>
                Bookings
            </a>

            <a href="{{ route('guest.manager') }}" wire:navigate @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                'bg-white/10 text-white' => request()->routeIs('guest.manager'),
                'text-white/80 hover:text-white hover:bg-white/5' => !request()->routeIs(
                    'guest.manager'),
            ])>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z" />
                </svg>
                Guests
            </a>
            @if (auth()->user()->isAdmin())
                <div x-data="{ openAccordion: {{ request()->routeIs('rooms.manager', 'room-units-manager') ? 'true' : 'false' }} }">
                    <button type="button" @click="openAccordion = !openAccordion" :aria-expanded="openAccordion"
                        class="flex w-full items-center justify-between rounded-xl px-4 py-3 font-medium text-white/80 transition-colors hover:bg-white/5 hover:text-white">
                        <span class="inline-flex text-sm gap-3">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5M3.75 21V9.75 6.75m0 3h16.5m-16.5 0 2.07-5.175A1.5 1.5 0 0 1 7.214 3.75h9.572a1.5 1.5 0 0 1 1.394.925l2.07 5.175m0 0V21m-12-7.5h.008v.008H8.25V13.5Zm3.75 0h.008v.008H12V13.5Zm3.75 0h.008v.008H15.75V13.5Z" />
                            </svg>
                            Room Management
                        </span>
                        <svg class="h-5 w-5 transition-transform duration-200" :class="openAccordion && 'rotate-90'"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-show="openAccordion" x-transition.opacity class="mt-1 space-y-1 pl-4">
                        <a href="{{ route('rooms.manager') }}" wire:navigate @class([
                            'flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors',
                            'bg-white/10 text-white' => request()->routeIs('rooms.manager'),
                            'text-white/80 hover:bg-white/5 hover:text-white' => !request()->routeIs(
                                'rooms.manager'),
                        ])>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5M3.75 21V9.75 6.75m0 3h16.5m-16.5 0 2.07-5.175A1.5 1.5 0 0 1 7.214 3.75h9.572a1.5 1.5 0 0 1 1.394.925l2.07 5.175m0 0V21m-12-7.5h.008v.008H8.25V13.5Zm3.75 0h.008v.008H12V13.5Zm3.75 0h.008v.008H15.75V13.5Z" />
                            </svg>
                            Rooms
                        </a>
                        @foreach ($sidebarRooms as $room)
                            <a href="{{ route('room-units-manager', $room->slug) }}" wire:navigate
                                @class([
                                    'flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors',
                                    'bg-white/10 text-white' => request()->route('roomSlug') === $room->slug,
                                    'text-white/80 hover:bg-white/5 hover:text-white' =>
                                        request()->route('roomSlug') !== $room->slug,
                                ])>
                                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3 6.75h.008v.008H3V6.75zm0 5.25h.008v.008H3v-5.25zm0 5.25h.008v.008H3v-5.25z" />
                                </svg>
                                <span class="truncate">{{ $room->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>



                <a href="{{ route('facilities.manager') }}" wire:navigate @class([
                    'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                    'bg-white/10 text-white' => request()->routeIs('facilities.manager'),
                    'text-white/80 hover:text-white hover:bg-white/5' => !request()->routeIs(
                        'facilities.manager'),
                ])>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                    </svg>
                    Facility
                </a>
            @endif
            <div x-data="{ openAccordion: {{ request()->routeIs('transaction.manager', 'promo-manager') ? 'true' : 'false' }} }">
                <button type="button" @click="openAccordion = !openAccordion" :aria-expanded="openAccordion"
                    class="flex w-full items-center justify-between rounded-xl px-4 py-3 font-medium text-white/80 transition-colors hover:bg-white/5 hover:text-white">
                    <span class="inline-flex items-center gap-3 text-sm">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.104c1.111.23 2.203-.63 2.203-1.765V4.91c0-.821-.548-1.54-1.34-1.742a60.05 60.05 0 0 0-16.66 0A1.75 1.75 0 0 0 .91 4.91v13.008c0 .97.786 1.756 1.756 1.756H4.5v-12.75a.75.75 0 0 1 .75-.75h.75m0 0h.75a.75.75 0 0 1 .75.75v12.75m0-12.75h.75a.75.75 0 0 1 .75.75v12.75" />
                        </svg>
                        Finance
                    </span>
                    <svg class="h-5 w-5 transition-transform duration-200" :class="openAccordion && 'rotate-90'"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="openAccordion" x-transition.opacity class="mt-1 space-y-1 pl-4">
                    <a href="{{ route('transaction.manager') }}" wire:navigate @class([
                        'flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors',
                        'bg-white/10 text-white' => request()->routeIs('transaction.manager'),
                        'text-white/80 hover:bg-white/5 hover:text-white' => !request()->routeIs(
                            'transaction.manager'),
                    ])>
                        Transaction
                    </a>
                    <a href="{{ route('promo-manager') }}" wire:navigate @class([
                        'flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors',
                        'bg-white/10 text-white' => request()->routeIs('promo-manager'),
                        'text-white/80 hover:bg-white/5 hover:text-white' => !request()->routeIs(
                            'promo-manager'),
                    ])>
                        Promo
                    </a>
                </div>
            </div>

        </nav>

        {{-- <div class="p-4 border-t border-white/10">
            <button
                class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white rounded-xl transition-colors text-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
                Log Out
            </button>
        </div> --}}
    </aside>
</div>
