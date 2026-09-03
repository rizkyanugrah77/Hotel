<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.show = true;
        this.toast.type = type;
        window.setTimeout(() => this.toast.show = false, 3000);
    }
}"
    x-on:room-saved.window="$dispatch('close-modal', 'manage-room'); showToast($event.detail.message, 'success')"
    x-on:room-deleted.window="$dispatch('close-modal', 'delete-room'); showToast($event.detail.message, 'success')"
    x-on:room-error.window="$dispatch('close-modal', 'manage-room'); showToast($event.detail.message, 'error')"
    x-on:room-editing.window="$dispatch('open-modal', 'manage-room')"
    x-on:manage-room-unit.window="$dispatch('open-modal', 'manage-room-unit', {roomId: $event.detail.roomId})"
    x-on:room-delete-confirmation.window="$dispatch('open-modal', 'delete-room')"
    class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
    {{-- toast --}}
    <x-toast />
    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm text-gray-500">Total Kamar</p>
                    <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $roomStats['total'] }}</h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5M3.75 21V9.75m0 0 2.07-5.175A1.5 1.5 0 0 1 7.214 3.75h9.572a1.5 1.5 0 0 1 1.394.925l2.07 5.175m0 0V21m-12-7.5h.008v.008H8.25V13.5Zm3.75 0h.008v.008H12V13.5Zm3.75 0h.008v.008H15.75V13.5Z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm text-gray-500">Available</p>
                    <h3 class="text-2xl font-poppins font-bold text-emerald-600">{{ $roomStats['available'] }}</h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><svg
                        class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 4.5 4.5 10.5-10.5" />
                    </svg></div>
            </div>
        </div>
        <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm text-gray-500">Occupied</p>
                    <h3 class="text-2xl font-poppins font-bold text-amber-600">{{ $roomStats['occupied'] }}</h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600"><svg
                        class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0" />
                    </svg></div>
            </div>
        </div>
        <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm text-gray-500">Maintenance</p>
                    <h3 class="text-2xl font-poppins font-bold text-red-600">{{ $roomStats['maintenance'] }}</h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600"><svg
                        class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75v5.25m0 3.75h.008v.008H12v-.008ZM10.29 3.86 2.82 16.36A1.5 1.5 0 0 0 4.107 18.6h15.786a1.5 1.5 0 0 0 1.287-2.24L13.71 3.86a1.5 1.5 0 0 0-2.574 0Z" />
                    </svg></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-[minmax(26rem,1.05fr)_minmax(0,0.95fr)] md:gap-6">
        {{-- room --}}
        <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-gray-100 p-4">
                <h2 class="font-poppins text-lg font-bold">Daftar Kamar</h2>
                <div class="grid w-full grid-cols-2 gap-2">
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Cari nama kamar..."
                        class="input col-span-2 py-2 text-sm">
                    <select wire:model.live="filterStatus" class="input min-w-0 py-2 text-sm">
                        <option value="">Semua Status</option>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    <button type="button" @click="$dispatch('open-modal', 'manage-room'); $wire.resetForm()"
                        class="btn-primary px-3 py-2 text-sm whitespace-nowrap sm:px-4">
                        Tambah Kamar
                    </button>
                </div>
            </div>

            <div class="divide-y divide-gray-100 md:hidden">
                @forelse ($rooms as $index => $room)
                    @php
                        $statusClasses =
                            $room->units->where('status', 'available')->count() < 1
                                ? 'badge badge-primary'
                                : 'badge badge-success';
                    @endphp
                    <article wire:key="room-mobile-{{ $room->id }}" wire:click="selectRoom({{ $room->id }})"
                        wire:keydown.enter="selectRoom({{ $room->id }})"
                        wire:keydown.space.prevent="selectRoom({{ $room->id }})" role="button" tabindex="0"
                        @class([
                            'cursor-pointer p-4 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-primary focus-within:bg-primary/5 hover:bg-gray-50',
                            'bg-primary/5' => $selectedRoom?->id === $room->id,
                        ])>
                        <div class="flex gap-3">
                            @if ($room->image)
                                <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}"
                                    alt="{{ $room->name }}" class="h-16 w-20 shrink-0 rounded-lg object-cover">
                            @else
                                <div
                                    class="flex h-16 w-20 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                    -</div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <h3 class="truncate font-semibold text-gray-900">{{ $room->name }}</h3>
                                        <p class="truncate text-xs text-gray-500">{{ $room->slug }}</p>
                                    </div>
                                    <span
                                        class="shrink-0 rounded-full px-2 py-1 text-xs font-medium {{ $statusClasses }}">
                                        {{ $room->units->where('status', 'available')->count() < 1 ? 'Occupied' : ucfirst($room->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center justify-between gap-3 text-xs">
                            <span class="text-gray-500">{{ $room->available_units_count }}/{{ $room->units_count }}
                                unit tersedia</span>
                            <span
                                class="shrink-0 font-semibold text-emerald-700">Rp{{ number_format($room->price, 0, ',', '.') }}</span>
                        </div>
                    </article>
                @empty
                    <p class="px-4 py-12 text-center text-sm text-gray-500">Belum ada kamar. Klik &ldquo;Tambah
                        Kamar&rdquo; untuk menambahkan kamar baru.</p>
                @endforelse
            </div>

            <div class="hidden md:block">
                <table class="w-full table-fixed text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="w-1/2 px-4 py-3 font-medium">Kamar</th>
                            <th class="w-1/4 px-4 py-3 font-medium">Ketersediaan</th>
                            <th class="w-1/4 px-4 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($rooms as $index => $room)
                            <tr wire:key="room-{{ $room->id }}" wire:click="selectRoom({{ $room->id }})"
                                wire:keydown.enter="selectRoom({{ $room->id }})"
                                wire:keydown.space.prevent="selectRoom({{ $room->id }})" role="button"
                                tabindex="0" @class([
                                    'cursor-pointer transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-primary hover:bg-gray-50',
                                    'bg-primary/5' => $selectedRoom?->id === $room->id,
                                ])>
                                @php
                                    $statusClasses =
                                        $room->units->where('status', 'available')->count() < 1
                                            ? 'badge badge-primary'
                                            : 'badge badge-success';
                                @endphp
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if ($room->image)
                                            <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}"
                                                alt="{{ $room->name }}" class="h-10 w-14 rounded-lg object-cover">
                                        @else
                                            <div
                                                class="flex h-10 w-14 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                                -</div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-gray-900">{{ $room->name }}</p>
                                            <p class="mt-1 truncate text-xs text-gray-500">
                                                Rp{{ number_format($room->price, 0, ',', '.') }} / malam</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800">
                                        {{ $room->available_units_count }}/{{ $room->units_count }} unit</p>
                                    <span
                                        class="mt-1 inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $statusClasses }}">{{ $room->units->where('status', 'available')->count() < 1 ? 'Occupied' : ucfirst($room->status) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="mt-1 inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $statusClasses }}">{{ ucfirst($room->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-gray-500">
                                    Belum ada kamar. Klik &ldquo;Tambah Kamar&rdquo; untuk menambahkan kamar baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- room-detail --}}
        <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm" aria-live="polite">
            @if ($selectedRoom)
                @php
                    $selectedStatusClasses =
                        $selectedRoom->available_units_count < 1 ? 'badge badge-primary' : 'badge badge-success';
                @endphp
                <div class="border-b border-gray-100 p-4 sm:p-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-poppins text-xl font-bold text-gray-900">{{ $selectedRoom->name }}
                                </h2>
                                <span
                                    class="rounded-full px-2 py-1 text-xs font-medium {{ $selectedStatusClasses }}">{{ $selectedRoom->available_units_count < 1 ? 'Occupied' : ucfirst($selectedRoom->status) }}</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{ $selectedRoom->slug }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="manageRoomUnit('{{ $selectedRoom->slug }}')"
                                class="btn-outline px-3 py-2 text-sm">Kelola Unit</button>
                            <x-edit-button :item="$selectedRoom" action="edit" />
                            <x-delete-button :item="$selectedRoom" confirmDelete="confirmDelete" />
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-[minmax(0,1fr)_5rem]">
                        <div class="order-2 flex gap-2 overflow-x-auto pb-1 sm:order-2 sm:max-h-80 sm:flex-col sm:overflow-x-hidden sm:overflow-y-auto sm:pb-0"
                            aria-label="Galeri kamar">
                            @forelse ($selectedRoom->galleries->take(5) as $gallery)
                                <img src="{{ asset('storage/assets/img/gallery/' . $gallery->image) }}"
                                    alt="{{ $gallery->caption ?: $selectedRoom->name }}"
                                    class="h-16 w-28 shrink-0 rounded-lg object-cover sm:h-20 sm:w-full">
                            @empty
                                <p class="text-xs text-gray-500">Belum ada galeri.</p>
                            @endforelse
                        </div>

                        <div class="order-1 sm:order-1">
                            @if ($selectedRoom->image)
                                <img src="{{ asset('storage/assets/img/rooms/' . $selectedRoom->image) }}"
                                    alt="{{ $selectedRoom->name }}"
                                    class="h-64 w-full rounded-xl object-cover sm:h-80">
                            @else
                                <div
                                    class="flex h-64 items-center justify-center rounded-xl bg-gray-100 text-sm text-gray-500 sm:h-80">
                                    Tidak ada gambar
                                </div>
                            @endif
                        </div>

                        <div class="order-3 sm:col-span-2 sm:order-3">
                            <p class="text-xl font-bold text-emerald-700">
                                Rp{{ number_format($selectedRoom->price, 0, ',', '.') }} <span
                                    class="text-sm font-normal text-gray-500">/ malam</span></p>
                            <dl class="mt-3 grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <dt class="text-gray-500">Ukuran</dt>
                                    <dd class="mt-1 font-medium text-gray-800">{{ $selectedRoom->size }} m&sup2;
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Tempat tidur</dt>
                                    <dd class="mt-1 font-medium text-gray-800">{{ $selectedRoom->bed_type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Kapasitas</dt>
                                    <dd class="mt-1 font-medium text-gray-800">{{ $selectedRoom->capacity }} orang
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Unit tersedia</dt>
                                    <dd class="mt-1 font-medium text-gray-800">
                                        {{ $selectedRoom->available_units_count }}/{{ $selectedRoom->units_count }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-gray-900">Deskripsi</h3>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">
                            {{ $selectedRoom->description }}</p>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-gray-900">Fasilitas</h3>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @forelse ($selectedRoom->facilities as $facility)
                                <span
                                    class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 [&>svg]:mr-1 [&>svg]:h-3.5 [&>svg]:w-3.5 [&>svg]:fill-current">{!! $facility->icon !!}{{ $facility->name }}</span>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada fasilitas untuk kamar ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-gray-900">Unit Kamar</h3>
                        <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
                            @forelse ($selectedRoom->units as $unit)
                                <div
                                    class="flex items-center justify-between rounded-lg border border-gray-200 px-3 py-2 text-sm">
                                    <span class="font-medium text-gray-800">{{ $unit->room_number }}</span>
                                    <span class="text-gray-600">{{ ucfirst($unit->status) }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada unit untuk kamar ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @else
                <div class="flex min-h-80 items-center justify-center p-6 text-center">
                    <div>
                        <h2 class="font-poppins text-lg font-bold text-gray-900">Pilih kamar</h2>
                        <p class="mt-2 text-sm text-gray-500">Pilih salah satu kamar dari daftar untuk melihat
                            detailnya.</p>
                    </div>
                </div>
            @endif
        </section>
    </div>

    <x-modal-2 name="manage-room-unit" :title="'Kelola Unit Kamar ' . ($managingRoom?->name ?? '')">
        <div class="space-y-4">
            @if ($managingRoom)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <p class="font-medium text-gray-800">{{ $managingRoom->name }}</p>
                        <p class="text-xs text-gray-500">Sisa Stok:
                            {{ $managingRoom->available_units_count }}</p>
                    </div>
                    <div>
                        <a href="{{ route('room-units-manager', $managingRoom->slug) }}" wire:navigate
                            class="btn-outline btn-sm text-black cursor-pointer hover:bg-green-200 hover:text-black">Kelola</a>
                    </div>

                </div>
                <div class="flex justify-between items-center px-3">
                    <p class="text-gray-800">Nomor Pintu Kamar</p>
                    <p class="text-gray-800">Status Kamar</p>
                </div>
                <div class="space-y-2 max-h-60 overflow-y-auto">
                    @forelse ($managingRoom->units as $unit)
                        @php
                            $unitStatusClasses = match ($unit->status) {
                                'available' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
                                'occupied' => 'border-amber-200 bg-amber-50 text-amber-800',
                                default => 'border-red-200 bg-red-50 text-red-800',
                            };
                            $unitBadgeClasses = match ($unit->status) {
                                'available' => 'bg-emerald-200 text-emerald-800',
                                'occupied' => 'bg-amber-200 text-amber-800',
                                default => 'bg-red-200 text-red-800',
                            };
                        @endphp
                        <div class="flex items-center justify-between rounded-xl border p-3 {{ $unitStatusClasses }}">
                            <span class="font-semibold">{{ $unit->room_number }}</span>
                            <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $unitBadgeClasses }}">
                                {{ ucfirst($unit->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-center text-gray-500 py-4">Belum ada unit yang dibuat untuk kamar
                            ini.
                        </p>
                    @endforelse
                </div>
            @endif
        </div>

    </x-modal-2>
    {{-- modal tambah --}}
    <x-modal-2 name="manage-room" :title="$editingRoomId ? 'Edit Kamar' : 'Tambah Kamar'">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="room-name" :value="__('Nama') . ' *'" />
                    <x-text-input wire:model="name" id="room-name" class="input"
                        placeholder="Contoh: Deluxe Lake View" required />
                    <x-input-error :message="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="room-bed-type" :value="__('Tipe Tempat Tidur') . ' *'" />
                    <select id="room-bed-type" wire:model="bed_type" class="input" required>
                        <option value="">Pilih tipe tempat tidur</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Twin">Twin</option>
                        <option value="Queen">Queen</option>
                        <option value="King">King</option>
                        <option value="Twin Double">Twin Double</option>
                    </select>
                    <x-input-error :message="$errors->get('bed_type')" />
                </div>
            </div>
            <div class="mb-2">
                <label class="label">Fasilitas</label>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">

                    @foreach ($facilities as $facility)
                        <label
                            class="border-2 rounded-lg p-3 cursor-pointer flex flex-col items-center justify-center gap-2 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 hover:border-gray-400">
                            <input type="checkbox" class="hidden peer" value="{{ $facility->id }}"
                                wire:model="selectedFacilities">

                            <div
                                class="w-8 h-8 text-gray-600 peer-checked:text-blue-600 [&>svg]:w-full [&>svg]:h-full">
                                {!! $facility->icon !!}
                            </div>

                            <span class="text-xs text-center text-gray-700 peer-checked:text-blue-700 font-medium">
                                {{ $facility->name }}
                            </span>

                        </label>
                    @endforeach
                </div>
                <x-input-error :message="$errors->get('selectedFacilities')" />
            </div>

            <div class="mb-4">
                <x-input-label for="room-description" :value="__('Deskripsi') . ' *'" />
                <textarea id="room-description" wire:model="description" class="input" rows="3"
                    placeholder="Deskripsi singkat mengenai kamar..." required></textarea>
                <x-input-error :message="$errors->get('description')" />
            </div>



            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="room-size" :value="__('Ukuran (m²)') . ' *'" />
                    <x-text-input wire:model="size" id="room-size" class="input" min="1" required />
                    <x-input-error :message="$errors->get('size')" />
                </div>

                <div>
                    <x-input-label for="room-stock" :value="__('Jumlah Stok') . ' *'" />
                    <div class="flex gap-2 items-center">
                        <x-secondary-button type="button" wire:click="decrement"
                            class="btn btn-outline text-black btn-sm w-8 h-8 cursor-pointer hover:bg-red-200 hover:text-black">-</x-secondary-button>
                        <x-text-input wire:model="room_stock" id="room-stock"
                            class="input w-20 text-center disabled:cursor-not-allowed appearance-none [-moz-appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                            min="1" required readonly />
                        <x-secondary-button type="button" wire:click="increment"
                            class="btn btn-outline text-black btn-sm w-8 h-8 cursor-pointer hover:bg-green-200 hover:text-black">+</x-secondary-button>
                        <x-input-error :message="$errors->get('room_stock')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="room-capacity" :value="__('Kapasitas (orang)') . ' *'" />
                    <x-text-input wire:model="capacity" id="room-capacity" class="input" min="1" required />
                    <x-input-error :message="$errors->get('capacity')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="room-price" :value="__('Harga per Malam (Rp)') . ' *'" />
                    <x-text-input wire:model="price" id="room-price" class="input" min="0" required />
                    <x-input-error :message="$errors->get('price')" />
                </div>
                <div>
                    <x-input-label for="room-status" :value="__('Status') . ' *'" />
                    <select id="room-status" wire:model="status" class="input" required>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    <x-input-error :message="$errors->get('status')" />
                </div>
            </div>

            <div>
                <x-input-label for="room-image" :value="__('Gambar Kamar') . ' ' . (!$editingRoomId ? '*' : '')" />
                <span class="text-sm text-red-500">Ukuran maksimal foto 2MB dan file JPG, JPEG, atau PNG</span>
                <x-text-input wire:model.live="image" type="file" id="room-image" class="input"
                    accept="image/jpg,image/jpeg,image/png" />

                <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-2">
                    Mengupload gambar...
                </div>

                @if ($image?->temporaryUrl())
                    <img src="{{ $image->temporaryUrl() }}" alt="{{ $name }}"
                        class="w-20 h-20 object-cover mt-4 mb-2 rounded-2xl">
                @endif
                <x-input-error :message="$errors->get('image')" />
            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 border-t border-gray-100 pt-4 sm:flex-row sm:justify-end">
                <button type="button" @click="$dispatch('close-modal', 'manage-room')"
                    class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                <x-primary-button wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">
                        {{ $editingRoomId ? 'Simpan Perubahan' : 'Simpan Kamar' }}
                    </span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-primary-button>
            </div>
        </form>
    </x-modal-2>

    {{-- modal delete --}}
    <x-modal-2 name="delete-room" title="Hapus Kamar">
        <p>Tindakan ini akan menghapus kamar beserta data booking terkait.</p>
        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="button" @click="$dispatch('close-modal', 'delete-room')"
                class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
            <x-danger-button wire:click="delete" wire:loading.attr="disabled" type="button">
                <span wire:loading.remove wire:target="delete">Hapus</span>
                <span wire:loading wire:target="delete">Menghapus...</span>
            </x-danger-button>
        </div>
    </x-modal-2>

</div>
