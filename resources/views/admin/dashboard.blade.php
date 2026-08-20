<div>

    <!-- Main Content Area -->
    <!-- Topbar -->
    <x-slot name="header">
        <div class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
            <h1 class="text-xl font-poppins font-bold text-foreground">Dashboard Overview</h1>
        </div>
    </x-slot>


    <!-- Content -->
    <main class="flex-1 overflow-y-auto p-8">

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Today's Revenue</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">Rp 12.4M</h3>
                    </div>
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-green-600 font-medium">+15% from yesterday</p>
            </div>

            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">24</h3>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 font-medium">8 new today</p>
            </div>

            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Occupancy Rate</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">78%</h3>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: 78%"></div>
                </div>
            </div>

            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Check-ins Today</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">12</h3>
                    </div>
                    <div class="w-10 h-10 bg-accent/10 text-accent-700 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 font-medium">4 pending arrival</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Bookings Table -->
            <div class="lg:col-span-2">
                <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="font-poppins font-bold text-lg">Recent Bookings</h2>
                        <button class="text-sm text-primary font-medium hover:underline">View All</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-gray-50 text-gray-500">
                                <tr>
                                    <th class="py-3 px-6 font-medium">Guest</th>
                                    <th class="py-3 px-6 font-medium">Room</th>
                                    <th class="py-3 px-6 font-medium">Dates</th>
                                    <th class="py-3 px-6 font-medium">Status</th>
                                    <th class="py-3 px-6 font-medium">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($rooms->flatMap->bookings as $booking)
                                    <tr class="hover:bg-gray-50 cursor-pointer">

                                        <td class="py-3 px-6">
                                            <div class="font-medium text-foreground">
                                                {{ $booking->booking_code }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->user->name }}</div>
                                        </td>
                                        <td class="py-3 px-6">
                                            <div class="font-medium text-foreground">
                                                {{ $booking->room->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->roomUnit->room_number }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-6">{{ $booking->check_in->format('d M Y') }} -
                                            {{ $booking->check_out->format('d M Y') }}</td>
                                        <td class="py-3 px-6">
                                            <span @class([
                                                'badge',
                                                'badge-primary' => $booking->status === 'pending',
                                                'badge-info' => $booking->status === 'paid',
                                                'badge-success' => $booking->status === 'checked_in',
                                                'badge-warning' => $booking->status === 'checked_out',
                                                'badge-accent' => $booking->status === 'cancelled',
                                            ])>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 font-medium">
                                            {{ $booking->total_price ? 'Rp ' . number_format($booking->total_price, 0, ',', '.') : 'Belum ada data' }}
                                        </td>
                                    @empty
                                        <td colspan="5" class="text-center py-6">Belum ada data</td>

                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Room Status Summary -->
            <div>
                <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                    <h2 class="font-poppins font-bold text-lg mb-6">Room Availability</h2>

                    <div class="space-y-4">
                        @forelse ($rooms as $room)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">{{ $room->name }}</span>
                                    <span
                                        class="font-medium badge-success">{{ $room->units->where('status', 'available')->count() }}
                                        / {{ $room->units->count() }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-emerald-500 "
                                        style="width: {{ ($room->units->where('status', 'available')->count() / $room->units->count()) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6">Belum ada data</div>
                        @endforelse

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="text-sm font-medium text-gray-600 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <button
                                class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                New Booking
                            </button>
                            <button
                                class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


</div>
