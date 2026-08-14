<div>
    <x-slot name="header">
        <div class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
            <h1 class="text-xl font-poppins font-bold text-foreground">Guest Management</h1>
        </div>
    </x-slot>

    <!-- Content -->
    <main class="flex-1 overflow-y-auto p-8">

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Guests</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $totalGuests }}</h3>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 font-medium">Registered customers</p>
            </div>

            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">New This Month</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $newGuestsThisMonth }}</h3>
                    </div>
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-green-600 font-medium">{{ now()->format('F Y') }}</p>
            </div>

            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Guests with Bookings</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $guestsWithBookings }}</h3>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                    <div class="bg-blue-600 h-1.5 rounded-full"
                        style="width: {{ $totalGuests > 0 ? round(($guestsWithBookings / $totalGuests) * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>

        <!-- Guest Table Card -->
        <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="font-poppins font-bold text-lg">Guest List</h2>
                <div class="relative w-full sm:w-72">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Search by name, email, phone..."
                        class="input pl-10 !py-2.5 !rounded-xl text-sm" />
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="py-3 px-6 font-medium">#</th>
                            <th class="py-3 px-6 font-medium">Guest</th>
                            <th class="py-3 px-6 font-medium">Phone</th>
                            <th class="py-3 px-6 font-medium">Address</th>
                            <th class="py-3 px-6 font-medium">Bookings</th>
                            <th class="py-3 px-6 font-medium">Total Spent</th>
                            <th class="py-3 px-6 font-medium">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($guests as $index => $guest)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 text-gray-400">
                                    {{ $guests->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-poppins font-semibold text-sm">
                                            {{ strtoupper(substr($guest->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-foreground">{{ $guest->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $guest->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    {{ $guest->phone ?? '—' }}
                                </td>
                                <td class="py-4 px-6 max-w-[200px] truncate">
                                    {{ $guest->address ?? '—' }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="badge-{{ $guest->bookings_count > 0 ? 'primary' : 'warning' }}">
                                        {{ $guest->bookings_count }} booking{{ $guest->bookings_count !== 1 ? 's' : '' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-medium">
                                    {{ $guest->total_spent ? 'Rp ' . number_format($guest->total_spent, 0, ',', '.') : '—' }}
                                </td>
                                <td class="py-4 px-6 text-gray-500">
                                    {{ $guest->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                        <p class="text-gray-400 font-medium">Belum ada guest terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($guests->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $guests->links() }}
                </div>
            @endif
        </div>
    </main>
</div>
