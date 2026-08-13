<x-guest-layout>

    <section id="rooms" class="section bg-gray-50/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-10">
                <h2 class="text-3xl sm:text-4xl font-poppins font-bold text-foreground">Featured Rooms</h2>
                <p class="mt-3 text-sm sm:text-base text-foreground/60 max-w-xl mx-auto">
                    Find the perfect room to suit your needs, from cozy single to spacious suites.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $rooms = \App\Models\Room::with('facilities')->latest()->get();
                @endphp

                @foreach ($rooms as $room)
                    <div
                        class="group flex flex-col bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_50px_rgba(0,0,0,0.12)] transition-all duration-500 hover:-translate-y-2 cursor-pointer">

                        <!-- Image Section -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ asset('assets/img/rooms/' . $room->image) }}" alt="{{ $room->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110"
                                loading="lazy" />

                            <!-- Subtle Gradient Overlay on Hover -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                            <!-- Floating Glassmorphism Badge -->
                            <div class="grid grid-cols-2 gap-2 absolute top-4 right-4">
                                <div
                                    class="flex items-center gap-2 bg-white/70 backdrop-blur-md px-3 py-1.5 rounded-full text-xs font-semibold text-gray-800 shadow-lg border border-white/20">
                                    <svg class="w-3.5 h-3.5 text-accent" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    <span>{{ $room->bed_type }} Bed{{ $room->bed_type > 1 ? 's' : '' }}</span>
                                </div>
                                <span
                                    class="badge-{{ $room->status === 'available' ? 'success' : ($room->status === 'maintenance' ? 'warning' : 'primary') }} capitalize flex w-24 items-center justify-center  backdrop-blur-md px-3 py-1.5 rounded-full text-xs font-semibold  shadow-lg border bg-white/70">
                                    {{ $room->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-6 flex flex-col flex-grow">

                            <!-- Title & Description -->
                            <h3
                                class="text-xl font-poppins font-bold text-gray-900 mb-2 group-hover:text-accent transition-colors duration-300">
                                {{ $room->name }}
                            </h3>
                            <p class="text-sm text-gray-500 leading-relaxed mb-6 line-clamp-2">
                                {{ $room->description }}
                            </p>

                            <!-- Divider -->
                            <hr class="border-gray-100 mb-5">

                            <!-- Footer: Facilities & Price -->
                            <div class="flex items-end justify-between mt-auto">

                                <!-- Facilities -->
                                <div class="flex flex-col gap-2">
                                    <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Fasilitas</span>
                                    <div class="flex items-center gap-3 text-sm text-gray-600">
                                        @foreach ($room->facilities->take(2) as $facility)
                                            <div class="flex items-center gap-1.5" title="{{ $facility->name }}">
                                                <span
                                                    class="text-accent [&>svg]:w-4 [&>svg]:h-4">{!! $facility->icon !!}</span>
                                                <span
                                                    class="truncate max-w-[80px] text-xs font-medium">{{ $facility->name }}</span>
                                            </div>
                                        @endforeach

                                        <!-- Tampilkan jika fasilitas lebih dari 2 -->
                                        @if ($room->facilities->count() > 2)
                                            <span
                                                class="text-xs text-gray-400 font-medium bg-gray-50 px-1.5 py-0.5 rounded-md">
                                                +{{ $room->facilities->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="flex flex-col text-right">
                                    <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Mulai
                                        Dari</span>
                                    <div class="flex items-baseline gap-1 justify-end">
                                        <span class="text-sm font-semibold text-primary">Rp</span>
                                        <span class="text-xl font-poppins font-bold text-primary">
                                            {{ number_format($room->price, 0, '.', ',') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if ($room->status === 'available')
                                <a href="{{ route('room-detail-preview', $room->slug) }}" wire:navigate
                                    class="btn-outline w-full mt-6 text-sm !py-2.5">
                                    View Details
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            @else
                                <a href="#"
                                    class="btn-outline w-full mt-6 text-sm !py-2.5 cursor-not-allowed disabled text-gray-500 border-gray-500 hover:bg-gray-500 hover:text-white">
                                    Room Not Available
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('welcome.footer')
</x-guest-layout>
