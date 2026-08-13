<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-14 animate-on-scroll">
        <div class="gold-line-center mb-4"></div>
        <h2 class="section-title">Our <span class="text-gradient-primary">Finest</span> Rooms</h2>
        {{-- <p class="section-subtitle mx-auto mt-4">Each room is thoughtfully designed to immerse you in the
            beauty of Samosir while providing world-class comfort.</p> --}}
    </div>

    <!-- Room Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($rooms as $room)
            <!-- Room Card 1 - Deluxe -->
            <div class="card group animate-on-scroll stagger" wire:key="{{ $room->id }}">
                @if ($room->image)
                    <div class="relative img-zoom rounded-t-3xl">
                        <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}" alt="{{ $room->name }}"
                            class="w-full h-64 object-cover" loading="lazy" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="capitalize badge-{{ $room->status === 'available' ? 'success' : ($room->status === 'maintenance' ? 'warning' : 'primary') }} backdrop-blur-md bg-white/70">
                                <svg class="w-3 h-3 " fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>
                                {{ $room->status }}
                            </span>
                        </div>
                        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm rounded-2xl px-4 py-2">
                            <span class="text-xs text-gray-500">From</span>
                            <span class="text-lg font-poppins font-bold text-primary ml-1">
                                {{ 'Rp ' . number_format($room->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-500">/night</span>
                        </div>
                    </div>
                @else
                    <div class="relative img-zoom rounded-t-3xl">
                        <img src="#" alt="{{ $room->name }}" class="w-full h-64 object-cover bg-gray-500"
                            loading="lazy" />
                        <div class="absolute top-4 left-4">
                            <span class="badge-accent">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>
                                {{ $room->status }}
                            </span>
                        </div>
                        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm rounded-2xl px-4 py-2">
                            <span class="text-xs text-gray-500">From</span>
                            <span class="text-lg font-poppins font-bold text-primary ml-1">Rp {{ $room->price }}</span>
                            <span class="text-xs text-gray-500">/night</span>
                        </div>
                    </div>
                @endif
                <div class="p-6">
                    {{-- <div class="flex items-center gap-1 mb-2">
                        <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        <span class="text-xs text-gray-500 ml-1">(4.9)</span>
                    </div> --}}
                    <h3 class="text-xl font-poppins font-bold text-foreground">{{ $room->name }}</h3>
                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $room->description }}</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            {{ $room->bed_type }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>
                            {{ $room->capacity }}
                        </span>
                        @foreach ($room->facilities->take(2) as $facility)
                            <span
                                class="flex items-center gap-1 overflow-hidden text-ellipsis whitespace-nowrap min-w-0">
                                <span
                                    class="[&>svg]:w-4 [&>svg]:h-4 [&>svg]:text-gray-500 [ [&>svg]:fill-current">{!! $facility->icon !!}</span>
                                <span class="truncate">{{ $facility->name }}</span>
                            </span>
                        @endforeach

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

    <!-- View All -->
    <div class="text-center mt-12 animate-on-scroll">
        <a href="{{ route('view-rooms') }}" wire:navigate class="btn-ghost text-base">
            View All Rooms
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>
</div>
