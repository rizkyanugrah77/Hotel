<div>
    <x-slot name="header">
        <div
            class="flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6 lg:h-20 lg:px-8">
            <h1 class="font-poppins text-lg font-bold text-foreground sm:text-xl">Guest Management</h1>
        </div>
    </x-slot>

    <!-- Content -->
    <main class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

        <!-- KPI Cards -->
        <div class="mb-6 grid grid-cols-2 gap-3 lg:mb-8 lg:grid-cols-3 lg:gap-6">
            <div class="card rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6">
                <div class="mb-2 flex items-start justify-between sm:mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Guests</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $totalGuests }}</h3>
                    </div>
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary sm:h-10 sm:w-10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="hidden text-xs font-medium text-gray-500 sm:block">Registered customers</p>
            </div>

            <div class="card rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:p-6">
                <div class="mb-2 flex items-start justify-between sm:mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">New This Month</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $newGuestsThisMonth }}</h3>
                    </div>
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-green-50 text-green-600 sm:h-10 sm:w-10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </div>
                </div>
                <p class="hidden text-xs font-medium text-green-600 sm:block">{{ now()->format('F Y') }}</p>
            </div>

            <div
                class="col-span-2 card rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5 lg:col-span-1 lg:p-6">
                <div class="mb-2 flex items-start justify-between sm:mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Guests with Bookings</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $guestsWithBookings }}</h3>
                    </div>
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-10 sm:w-10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
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
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <!-- Table Header -->
            <div
                class="flex flex-col items-start justify-between gap-3 border-b border-gray-100 p-4 sm:p-5 md:flex-row md:items-center lg:p-6">
                <h2 class="font-poppins font-bold text-lg">Guest List</h2>
                <div class="relative w-full md:w-72">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Search by name, email, phone..." class="input pl-10 !py-2.5 !rounded-xl text-sm" />
                </div>
            </div>

            <!-- Mobile Guest Cards -->
            <div class="divide-y divide-gray-100 md:hidden">
                @forelse ($guests as $index => $guest)
                    <article wire:key="guest-mobile-{{ $guest->id }}" class="p-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary/10 font-poppins text-sm font-semibold text-primary">
                                {{ strtoupper(substr($guest->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-foreground">{{ $guest->name }}</p>
                                        <p class="mt-0.5 truncate text-xs text-gray-500">{{ $guest->email }}</p>
                                    </div>
                                    <span
                                        class="shrink-0 text-xs text-gray-400">#{{ $guests->firstItem() + $index }}</span>
                                </div>
                                <div
                                    class="mt-3 grid grid-cols-2 gap-x-3 gap-y-2 border-t border-gray-100 pt-3 text-xs">
                                    <div>
                                        <p class="text-gray-400">Phone</p>
                                        <p class="mt-0.5 truncate font-medium text-gray-700">{{ $guest->phone ?? '—' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Joined</p>
                                        <p class="mt-0.5 font-medium text-gray-700">
                                            {{ $guest->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Bookings</p>
                                        <span
                                            class="mt-0.5 badge-{{ $guest->bookings_count > 0 ? 'primary' : 'warning' }}">
                                            {{ $guest->bookings_count }}
                                            booking{{ $guest->bookings_count !== 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Total spent</p>
                                        <p class="mt-0.5 truncate font-semibold text-emerald-700">
                                            {{ $guest->total_spent ? 'Rp ' . number_format($guest->total_spent, 0, ',', '.') : '—' }}
                                        </p>
                                    </div>
                                </div>
                                @if ($guest->address)
                                    <p class="mt-2 truncate text-xs text-gray-500">{{ $guest->address }}</p>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="flex flex-col items-center gap-3 px-4 py-12 text-center">
                        <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-400">Belum ada guest terdaftar</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Guest Table -->
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full min-w-[760px] text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-4 py-3 font-medium">#</th>
                            <th class="px-4 py-3 font-medium">Guest</th>
                            <th class="px-4 py-3 font-medium">Phone</th>
                            <th class="px-4 py-3 font-medium">Jenis Kelamin</th>
                            <th class="px-4 py-3 font-medium">Identitas</th>
                            <th class="px-4 py-3 font-medium">Warga Negara</th>
                            <th class="px-4 py-3 font-medium">Bookings</th>
                            <th class="px-4 py-3 font-medium">Total Spent</th>
                            <th class="px-4 py-3 font-medium">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($guests as $index => $guest)
                            <tr wire:key="guest-desktop-{{ $guest->id }}"
                                class="transition-colors hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-400">
                                    {{ $guests->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
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
                                <td class="px-4 py-3">
                                    {{ $guest->phone ?? '—' }}
                                </td>
                                <td class="max-w-[180px] truncate px-4 py-3">
                                    {{ $guest->gender ?? '—' }}
                                </td>
                                <td class="max-w-[180px] truncate px-4 py-3">
                                    {{ $guest->identity_type ? ucfirst($guest->identity_type) : '—' }}
                                </td>
                                <td class="max-w-[180px] truncate px-4 py-3">
                                    {{ $guest->nationality && $guest->nationality != 'indonesian' ? 'WNI' : ucfirst($guest->nationality) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge-{{ $guest->bookings_count > 0 ? 'primary' : 'warning' }}">
                                        {{ $guest->bookings_count }}
                                        booking{{ $guest->bookings_count !== 1 ? 's' : '' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium">
                                    {{ $guest->total_spent ? 'Rp ' . number_format($guest->total_spent, 0, ',', '.') : '—' }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $guest->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
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
                <div class="border-t border-gray-100 p-4 sm:p-5 lg:p-6">
                    {{ $guests->links() }}
                </div>
            @endif
        </div>
    </main>
</div>
