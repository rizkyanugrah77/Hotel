 <!-- Main Content Area -->
 <div class="flex-1 flex flex-col h-screen overflow-hidden">

     <!-- Content -->
     <main class="flex-1 overflow-y-auto p-8">

         <!-- KPI Cards -->
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
             <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                 <div class="flex justify-between items-start mb-4">
                     <div>
                         <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
                         <h3 class="text-2xl font-poppins font-bold text-foreground" id="kpiTotal">0</h3>
                     </div>
                     <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                         </svg>
                     </div>
                 </div>
                 <p class="text-xs text-gray-500 font-medium" id="kpiTotalSub">Semua booking</p>
             </div>

             <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                 <div class="flex justify-between items-start mb-4">
                     <div>
                         <p class="text-sm text-gray-500 mb-1">Confirmed</p>
                         <h3 class="text-2xl font-poppins font-bold text-emerald-600" id="kpiConfirmed">0</h3>
                     </div>
                     <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                         </svg>
                     </div>
                 </div>
                 <p class="text-xs text-emerald-600 font-medium" id="kpiConfirmedSub">Booking aktif</p>
             </div>

             <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                 <div class="flex justify-between items-start mb-4">
                     <div>
                         <p class="text-sm text-gray-500 mb-1">Pending</p>
                         <h3 class="text-2xl font-poppins font-bold text-amber-600" id="kpiPending">0</h3>
                     </div>
                     <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                         </svg>
                     </div>
                 </div>
                 <p class="text-xs text-amber-600 font-medium" id="kpiPendingSub">Menunggu konfirmasi</p>
             </div>

             <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                 <div class="flex justify-between items-start mb-4">
                     <div>
                         <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                         <h3 class="text-2xl font-poppins font-bold text-accent-700" id="kpiRevenue">Rp 0</h3>
                     </div>
                     <div class="w-10 h-10 bg-accent/10 text-accent-700 rounded-xl flex items-center justify-center">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                         </svg>
                     </div>
                 </div>
                 <p class="text-xs text-accent-600 font-medium" id="kpiRevenueSub">Dari confirmed booking</p>
             </div>
         </div>

         <!-- Action Bar & Table -->
         <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden mb-8">
             <div
                 class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                 <h2 class="font-poppins font-bold text-lg">Daftar Booking</h2>
                 <div class="flex items-center gap-3 flex-wrap">
                     <div class="relative">
                         <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                         </svg>
                         <input type="text" id="searchInput" placeholder="Cari booking code, user..."
                             class="input pl-10 pr-4 py-2 text-sm w-64" oninput="filterBookings()" />
                     </div>
                     <select id="filterStatus" class="input py-2 text-sm w-40" onchange="filterBookings()">
                         <option value="">Semua Status</option>
                         <option value="confirmed">Confirmed</option>
                         <option value="pending">Pending</option>
                         <option value="checked_in">Checked In</option>
                         <option value="checked_out">Checked Out</option>
                         <option value="cancelled">Cancelled</option>
                     </select>
                     <select id="filterRoom" class="input py-2 text-sm w-44" onchange="filterBookings()">
                         <option value="">Semua Room</option>
                     </select>
                     <button onclick="openModal()" class="btn-primary text-sm px-4 py-2">
                         <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                         </svg>
                         Tambah Booking
                     </button>
                 </div>
             </div>
             <div class="overflow-x-auto">
                 <table class="w-full text-left text-sm whitespace-nowrap" id="bookingsTable">
                     <thead class="bg-gray-50 text-gray-500">
                         <tr>
                             <th class="py-3 px-6 font-medium">No</th>
                             <th class="py-3 px-6 font-medium">Booking Code</th>
                             <th class="py-3 px-6 font-medium">Room</th>
                             <th class="py-3 px-6 font-medium">User ID</th>
                             <th class="py-3 px-6 font-medium">Check In</th>
                             <th class="py-3 px-6 font-medium">Check Out</th>
                             <th class="py-3 px-6 font-medium">Guests</th>
                             <th class="py-3 px-6 font-medium">Total Price</th>
                             <th class="py-3 px-6 font-medium">Status</th>
                             <th class="py-3 px-6 font-medium text-center">Actions</th>
                         </tr>
                     </thead>
                     <tbody class="divide-y divide-gray-100" id="bookingsBody">
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Reports Section -->
         <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
             <!-- Booking per Room -->
             <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                 <h2 class="font-poppins font-bold text-lg mb-6">Booking per Room</h2>
                 <div class="space-y-4" id="reportByRoom">
                 </div>
             </div>

             <!-- Revenue Statistics -->
             <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                 <h2 class="font-poppins font-bold text-lg mb-6">Statistik Revenue</h2>
                 <div class="space-y-4">
                     <div class="p-4 bg-gray-50 rounded-xl">
                         <p class="text-sm text-gray-500 mb-1">Total Revenue (Confirmed)</p>
                         <p class="text-xl font-poppins font-bold text-accent-700" id="statRevenue">Rp 0</p>
                     </div>
                     <div class="p-4 bg-gray-50 rounded-xl">
                         <p class="text-sm text-gray-500 mb-1">Rata-rata per Booking</p>
                         <p class="text-xl font-poppins font-bold text-foreground" id="statAvgPrice">Rp 0</p>
                     </div>
                     <div class="p-4 bg-gray-50 rounded-xl">
                         <p class="text-sm text-gray-500 mb-1">Booking Tertinggi</p>
                         <p class="text-xl font-poppins font-bold text-primary" id="statHighest">Rp 0</p>
                     </div>
                     <div class="p-4 bg-gray-50 rounded-xl">
                         <p class="text-sm text-gray-500 mb-1">Total Tamu</p>
                         <p class="text-xl font-poppins font-bold text-blue-600" id="statTotalGuests">0</p>
                     </div>
                 </div>
             </div>

             <!-- Status Summary & Quick Actions -->
             <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                 <h2 class="font-poppins font-bold text-lg mb-6">Status Booking</h2>
                 <div class="space-y-4" id="statusReport">
                 </div>
                 <div class="mt-6 pt-6 border-t border-gray-100">
                     <h3 class="text-sm font-medium text-gray-600 mb-3">Aksi Cepat</h3>
                     <div class="grid grid-cols-2 gap-3">
                         <button onclick="openModal()"
                             class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                             <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                             </svg>
                             Tambah Booking
                         </button>
                         <button onclick="exportReport()"
                             class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                             <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                             </svg>
                             Export Laporan
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </main>
 </div>
