 <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
     <div>
         <h1 class="text-2xl sm:text-3xl font-poppins font-bold text-foreground">
             Selamat Datang, <span class="text-gradient-primary">{{ $user->name }}</span> 👋
         </h1>
         <p class="text-sm sm:text-base text-gray-500 mt-1 font-inter">
             {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
         </p>
     </div>
     <a href="{{ route('view-rooms') }}" wire:navigate class="btn-primary text-sm !px-5 !py-2.5 w-fit">
         <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
         </svg>
         Book Kamar
     </a>
 </div>
