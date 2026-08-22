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
                <div class="md:col-span-3  max-h-[530px] md:h-full rounded-3xl overflow-hidden cursor-pointer group"
                    data-gallery-item>
                    <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}" alt="Deluxe Room main view"
                        class="w-full  h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                </div>

                <div class="grid grid-cols-2 md:grid-cols-1 gap-4 md:col-span-1 h-[150px] md:h-full">
                    @if ($room->galleries)
                        @foreach ($room->galleries->where('is_featured', 1)->take(3) as $galleri)
                            <div class="rounded-3xl overflow-hidden cursor-pointer group h-full md:max-h-[160px]"
                                data-gallery-item>
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
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="badge-accent">Popular</span>
                        <span class="badge bg-gray-100 text-gray-700">{{ $room->size }} m²</span>
                        {{-- <span class="badge bg-gray-100 text-gray-700"></span> --}}
                    </div>
                    <h1 class="text-3xl md:text-4xl font-poppins font-bold text-red-600 mb-4">{{ $room->name }}
                    </h1>

                    {{-- <div class="flex items-center gap-1 text-sm text-gray-600 mb-8">
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
                    </div> --}}

                    <!-- Description -->
                    <div class="mb-10">
                        <h2 class="text-xl font-poppins font-bold text-foreground mb-6">Description</h2>
                        <p>{!! $room->description !!}</p>
                    </div>

                    <hr class="border-gray-500 mb-10">

                    <!-- Amenities -->
                    <h2 class="text-xl font-poppins font-bold text-foreground mb-6">Room Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4 mb-12">
                        @foreach ($room->facilities as $facility)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                                    {!! $facility->icon !!}
                                </div>
                                <span class="text-sm font-medium">{{ $facility->name }}</span>
                            </div>
                        @endforeach
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
                                    <input type="date" class="input !py-2 !px-3 text-sm" wire:model.live="check_in"
                                        min="{{ now()->toDateString() }}" required />
                                    <x-input-error :message="$errors->first('check_in')" class="mt-1 text-sm" />
                                </div>
                                <div>
                                    <label class="input-label text-xs">Check Out</label>
                                    <input type="date" class="input !py-2 !px-3 text-sm" wire:model.live="check_out"
                                        min="{{ $check_in ?: now()->toDateString() }}" required />
                                    <x-input-error :message="$errors->first('check_out')" class="mt-1 text-sm" />
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
                                <x-input-error :message="$errors->first('total_guests')" class="mt-1 text-sm" />
                            </div>

                            <div>
                                <label class="input-label text-xs">Promo Code</label>
                                <div class="flex gap-2">
                                    <input type="text" wire:model.live="promo_code" class="input !py-2 !px-3 text-sm"
                                        placeholder="Masukkan kode promo" />
                                    <button type="button" wire:click="applyPromo" wire:loading.attr="disabled"
                                        wire:target="applyPromo" class="btn-primary !px-4 !py-2 text-sm">Pakai</button>
                                </div>
                                <x-input-error :message="$errors->first('promo_code')" class="mt-1 text-sm" />
                                @if ($promo)
                                    <p class="mt-1 text-xs text-green-600">Promo {{ $promo->code }} diterapkan.</p>
                                @endif
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
                                @if ($discount_amount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>Promo {{ $promo->code }}</span>
                                        <span>-{{ 'Rp ' . number_format($discount_amount, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-gray-600">
                                    <span>Taxes & Fees (11%)</span>
                                    <span>{{ 'Rp ' . number_format($tax_amount, 0, ',', '.') }}</span>
                                </div>
                                <div
                                    class="border-t border-gray-200 pt-2 mt-2 flex justify-between font-bold text-foreground">
                                    <span>Total</span>
                                    <span>{{ 'Rp ' . number_format($total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if (Auth::check())
                                <button type="submit" wire:loading.attr="disabled" class="btn-primary w-full mt-6">
                                    <span wire:loading.remove wire:target="save" class="relative">Reserve Now</span>
                                    <span wire:loading wire:target="save" class="loading">Loading...</span>
                                </button>
                            @else
                                <a href="{{ route('login') }}" wire:navigate class="btn-primary w-full mt-6">
                                    <span class="relative">Reserve Now</span>
                                </a>
                            @endif

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
