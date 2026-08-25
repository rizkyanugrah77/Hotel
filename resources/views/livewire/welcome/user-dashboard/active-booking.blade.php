 <section class="lg:col-span-2 animate-fade-in-up delay-4" id="active-bookings">
     <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
         <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center">
             <h2 class="font-poppins font-bold text-lg text-foreground">Booking Aktif</h2>
             <span class="badge-primary">{{ $activeCount }} aktif</span>
         </div>

         <div class="divide-y divide-gray-50">
             @forelse($activeBookings as $booking)
                 <div class="p-4 sm:p-5 hover:bg-gray-50/50 transition-colors">
                     <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                         <!-- Room image placeholder -->
                         <div
                             class="w-full sm:w-20 h-28 sm:h-16 bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                             @if ($booking->room && $booking->room->image)
                                 <img src="{{ asset('storage/assets/img/rooms/' . $booking->room->image) }}"
                                     alt="{{ $booking->room->name }}" class="w-full h-full object-cover">
                             @else
                                 <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                     stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M2.25 21h19.5M3.75 21V9.75 6.75m0 3h16.5m-16.5 0 2.07-5.175A1.5 1.5 0 0 1 7.214 3.75h9.572a1.5 1.5 0 0 1 1.394.925l2.07 5.175m0 0V21" />
                                 </svg>
                             @endif
                         </div>

                         <!-- Booking info -->
                         <div class="flex-1 min-w-0">
                             <form wire:submit="cancel({{ $booking->id }})">
                                 <div class="flex items-start justify-between gap-2">
                                     <div class="grid grid-cols-2 gap-2">
                                         <h3 class="text-sm font-semibold text-foreground">
                                             {{ $booking->room->name ?? 'Room' }}</h3>
                                         <p class="text-xs text-gray-400 mt-0.5">{{ $booking->booking_code }}</p>
                                         <div class="flex space-x-2 my-1">
                                             @if ($booking->status === 'pending')
                                                 <a href="{{ route('payment', $booking->booking_code) }}" wire:navigate
                                                     class="btn-sm text-xs text-white bg-red-800 hover:bg-red-700 rounded-lg px-2 py-1">
                                                     Bayar Sekarang
                                                 </a>
                                             @endif
                                         </div>
                                     </div>

                                     <span
                                         class="badge-{{ $booking->status === 'paid' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'cancelled' ? 'danger' : '')) }} flex-shrink capitalize ">{{ ucfirst($booking->status) }}</span>

                                 </div>

                                 <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-gray-500">
                                     <span class="flex items-center gap-1">
                                         <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                         </svg>
                                         {{ $booking->check_in->format('d M') }} —
                                         {{ $booking->check_out->format('d M Y') }}
                                     </span>
                                     <span class="flex items-center gap-1">
                                         <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                         </svg>
                                         {{ $booking->total_guests }} tamu
                                     </span>
                                     <span class="font-semibold text-foreground">
                                         Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                     </span>
                                 </div>
                                 @if ($booking->status === 'pending')
                                     <div
                                         class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-gray-500">
                                         <button type="submit"
                                             class="btn-sm text-xs text-white bg-red-800 hover:bg-red-700 rounded-lg px-2 py-1">
                                             Cancel
                                         </button>
                                     </div>
                                 @endif
                             </form>
                         </div>
                     </div>
                 </div>
             @empty
                 <div class="p-8 sm:p-12 text-center">
                     <div class="w-16 h-16 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                         <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                             stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                         </svg>
                     </div>
                     <p class="text-sm text-gray-500 font-medium">Belum ada booking aktif</p>
                     <p class="text-xs text-gray-400 mt-1">Yuk jelajahi kamar kami dan booking sekarang!</p>
                     <a href="{{ route('index') }}" wire:navigate
                         class="btn-primary text-sm !px-5 !py-2.5 mt-4 inline-flex">
                         Jelajahi Kamar
                     </a>
                 </div>
             @endforelse
         </div>
     </div>
 </section>
