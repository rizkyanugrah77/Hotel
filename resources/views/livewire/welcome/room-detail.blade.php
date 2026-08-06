<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.show = true;
        this.toast.type = type;
        window.setTimeout(() => this.toast.show = false, 5000);
    }
}" x-on:room-detail-saved.window="showToast($event.detail.message, $event.detail.type)"
    x-on:room-detail-error.window="showToast($event.detail.message, $event.detail.type)">
    <main class="pt-28 pb-16 px-4">
        <x-toast />
        <div class="max-w-7xl mx-auto">

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <a href="{{ route('index') }}" class="hover:text-primary transition-colors">Home</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('index') }}" class="hover:text-primary transition-colors">Rooms</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-foreground font-medium">{{ $room->name }}</span>
            </nav>

            <!-- Image Gallery -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12 h-auto md:h-[500px]">
                <div class="md:col-span-3  max-h-[520px] md:h-full rounded-3xl overflow-hidden cursor-pointer group"
                    data-gallery-item>
                    <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}" alt="Deluxe Room main view"
                        class="w-full  h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                </div>
                <div class="grid grid-cols-2 md:grid-cols-1 gap-4 md:col-span-1 h-[150px] md:h-full">
                    @if ($room->galleries)
                        @foreach ($room->galleries->where('is_featured', 1)->take(3) as $galleri)
                            <div class="rounded-3xl overflow-hidden cursor-pointer group h-full" data-gallery-item>
                                <img src="{{ asset('storage/assets/img/gallery/' . $galleri->image) }}"
                                    alt="Room details"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                            </div>
                        @endforeach
                    @endif
                    {{-- @if ($room->galleries->count() > 4)
                        <div class="rounded-3xl overflow-hidden cursor-pointer group h-full relative" data-gallery-item>
                            <img src="{{ asset('storage/assets/img/gallery/' . $room->image) }}" alt="Balcony view"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <span class="text-white font-poppins font-medium">+{{ $room->galleries->count() - 4 }}
                                    Photos</span>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Left Column: Details -->
                <div class="lg:col-span-2">
                    <!-- Title & Badges -->
                    <div class="flex flex-wrap items-center gap-3 mb-4 ml-4">
                        <span class="badge-accent">Popular</span>
                        <span class="badge bg-gray-100 text-gray-700">{{ $room->size }} m²</span>
                        {{-- <span class="badge bg-gray-100 text-gray-700"></span> --}}
                    </div>
                    <h1 class="text-3xl md:text-4xl font-poppins font-bold text-red-600 mb-4 ml-4">{{ $room->name }}
                    </h1>

                    <div class="flex items-center gap-1 text-sm text-gray-600 mb-8">
                        <div class="flex text-accent">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            <!-- Repeat 4x -->
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                        </div>
                        <span class="font-medium text-foreground ml-1">4.9</span> (128 reviews)
                    </div>

                    <!-- Description -->
                    <div class="prose prose-gray max-w-none mb-10">
                        <p>Immerse yourself in the breathtaking beauty of Samosir Island from our Deluxe Lake View
                            Room. Featuring floor-to-ceiling windows and a private balcony, this room offers
                            uninterrupted panoramic views of the magnificent Lake Toba.</p>
                        <p>The interior blends modern luxury with subtle Batak cultural touches, including handwoven
                            ulos textile accents and local woodwork. The spacious 45 sqm room comes equipped with a
                            king-size premium bed, a plush seating area, and a marble bathroom with a rain shower.
                        </p>
                    </div>

                    <!-- Amenities -->
                    <h2 class="text-xl font-poppins font-bold text-foreground mb-6">Room Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4 mb-12">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium">{{ $room->bed_type }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Free High-Speed WiFi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium">55" Smart TV</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Private Balcony</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Minibar</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0 6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.055.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Room Service</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Booking Widget -->
                <div>
                    <div class="card p-6 sticky top-28 border border-gray-100 shadow-soft-lg">
                        <div class="flex items-end gap-2 mb-6 pb-6 border-b border-gray-100">
                            <span
                                class="text-3xl font-poppins font-bold text-primary">{{ 'Rp ' . number_format($room->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-500 mb-1">/ night</span>
                        </div>

                        <form wire:submit.prevent="save" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="input-label text-xs">Check In</label>
                                    <input type="date" class="input !py-2 !px-3 text-sm"
                                        wire:model.live="check_in" min="{{ now()->toDateString() }}" required />
                                </div>
                                <div>
                                    <label class="input-label text-xs">Check Out</label>
                                    <input type="date" class="input !py-2 !px-3 text-sm"
                                        wire:model.live="check_out" min="{{ $check_in ?: now()->toDateString() }}"
                                        required />
                                </div>
                            </div>

                            <div>
                                <label class="input-label text-xs">Guests</label>
                                <select wire:model.live="total_guests" class="input !py-2 !px-3 text-sm">
                                    @foreach (range(1, 4) as $guest)
                                        <option value="{{ $guest }}">{{ $guest }} Guest
                                            {{ $guest > 2 ? ' (+Rp 300K)' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="bg-gray-50 rounded-xl p-4 mt-6 space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>{{ 'Rp ' . number_format($room->price, 0, ',', '.') }} x
                                        {{ max($nights, 1) }}
                                        nights</span>
                                    <span>{{ 'Rp ' . number_format($room->price * max($nights, 1), 0, ',', '.') }}</span>
                                </div>
                                @if ($total_guests > 2)
                                    <div class="flex justify-between text-gray-600">
                                        <span>Extra Guests x {{ max($nights, 1) }} nights</span>
                                        <span>{{ 'Rp ' . number_format(($total_guests - 2) * 300000 * max($nights, 1), 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-gray-600">
                                    <span>Taxes & Fees (11%)</span>
                                    @php
                                        $base = $room->price * max($nights, 1);
                                        $extra = $total_guests > 2 ? ($total_guests - 2) * 300000 * max($nights, 1) : 0;
                                        $taxes = ($base + $extra) * 0.11;
                                    @endphp
                                    <span>{{ 'Rp ' . number_format($taxes, 0, ',', '.') }}</span>
                                </div>
                                <div
                                    class="border-t border-gray-200 pt-2 mt-2 flex justify-between font-bold text-foreground">
                                    <span>Total</span>
                                    <span>{{ 'Rp ' . number_format($total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" wire:loading.attr="disabled" class="btn-primary w-full mt-6">
                                <span wire:loading.remove wire:target="save" class="relative">Reserve Now</span>
                                <span wire:loading wire:target="save" class="loading">Loading...</span>
                            </button>


                            <p class="text-xs text-center text-gray-500 mt-3">You won't be charged yet</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- LIGHTBOX -->
    <div id="gallery-lightbox"
        class="fixed inset-0 z-[60] bg-black/90 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <button id="lightbox-close" class="absolute top-6 right-6 text-white hover:text-accent transition-colors"><svg
                class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg></button>
        <img id="lightbox-img" src="" alt="Expanded view"
            class="max-w-[90vw] max-h-[85vh] object-contain rounded-2xl" />
    </div>
</div>
