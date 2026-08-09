<section class="space-y-6 animate-fade-in-up delay-5" id="sidebar-widgets">

    <!-- Quick Actions -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 sm:p-6">
        <h2 class="font-poppins font-bold text-lg text-foreground mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('index') }}#rooms" wire:navigate
                class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-primary hover:border-primary hover:shadow-red transition-all duration-300">
                <div
                    class="w-10 h-10 mx-auto bg-primary/10 group-hover:bg-white/20 text-primary group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Lihat
                    Room</span>
            </a>

            <a href="{{ route('index') }}#rooms" wire:navigate
                class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-accent hover:border-accent hover:shadow-gold transition-all duration-300">
                <div
                    class="w-10 h-10 mx-auto bg-accent/10 group-hover:bg-white/20 text-accent-700 group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Book
                    Kamar</span>
            </a>

            <a href="{{ route('profile') }}" wire:navigate
                class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-blue-500 hover:border-blue-500 transition-all duration-300">
                <div
                    class="w-10 h-10 mx-auto bg-blue-50 group-hover:bg-white/20 text-blue-600 group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Profil</span>
            </a>

            <a href="#booking-history"
                class="group p-4 border border-gray-100 rounded-xl text-center hover:bg-emerald-500 hover:border-emerald-500 transition-all duration-300">
                <div
                    class="w-10 h-10 mx-auto bg-emerald-50 group-hover:bg-white/20 text-emerald-600 group-hover:text-white rounded-xl flex items-center justify-center mb-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span
                    class="text-xs font-semibold text-gray-700 group-hover:text-white transition-colors">Riwayat</span>
            </a>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 sm:p-6">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="w-12 h-12 rounded-full bg-gradient-primary text-white flex items-center justify-center text-lg font-bold shadow-red">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <h3 class="text-sm font-semibold text-foreground truncate">{{ $user->name }}</h3>
                <p class="text-xs text-gray-400">Member sejak {{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center gap-2.5 text-sm">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <span class="text-gray-600 truncate">{{ $user->email }}</span>
            </div>

            @if ($user->phone)
                <div class="flex items-center gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    <span class="text-gray-600">{{ $user->phone }}</span>
                </div>
            @endif

            @if ($user->address)
                <div class="flex items-start gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="text-gray-600 line-clamp-2">{{ $user->address }}</span>
                </div>
            @endif
        </div>

        <a href="{{ route('profile') }}" wire:navigate
            class="mt-4 w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-sm font-medium text-primary border border-primary/20 rounded-xl hover:bg-primary/5 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
            Edit Profil
        </a>
    </div>
</section>
