   @foreach ($upcomingCheckins as $checkin)
       <div
           class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/60 rounded-2xl p-4 sm:p-5 flex items-start gap-3 mb-3 last:mb-0 shadow-sm">
           <div
               class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
               <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round"
                       d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
               </svg>
           </div>
           <div class="flex-1 min-w-0">
               <p class="text-sm font-semibold text-amber-800">
                   🔔 Check-in {{ $checkin->check_in->diffForHumans() }}
               </p>
               <p class="text-xs text-amber-600 mt-0.5">
                   <span class="font-medium">{{ $checkin->room->name ?? 'Room' }}</span> —
                   {{ $checkin->check_in->format('d M Y') }} s/d {{ $checkin->check_out->format('d M Y') }}
               </p>
               <p class="text-xs text-amber-500 mt-0.5">Kode: {{ $checkin->booking_code }}</p>
           </div>
       </div>
   @endforeach
