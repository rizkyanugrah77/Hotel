<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.type = type;
        this.toast.show = true;
        window.setTimeout(() => this.toast.show = false, 3000);
    }
}" x-on:open-modal-edit-unit.window="$dispatch('open-modal', 'manage-room-unit')"
    x-on:room-unit-saved.window="$dispatch('close-modal', 'manage-room-unit'), $dispatch('show-toast', $event.detail.message, $event.detail.type)"
    x-on:room-number-deleted.window="$dispatch('close-modal', 'manage-room-unit'), $dispatch('show-toast', $event.detail.message, 'success')"
    x-on:room-number-deleted.window="$dispatch('room-unit-delete-confirmation')"
    x-on:room-number-deleted-error.window="$dispatch('show-toast', $event.detail.message, 'error')"
    class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
    <x-toast />

    @php
        $unitCollection = collect($units);
        $registeredUnits = $unitCollection->count();
        $availableUnits = $unitCollection->where('status', 'available')->count();
        $occupiedUnits = $unitCollection->where('status', 'occupied')->count();
        $maintenanceUnits = $unitCollection->where('status', 'maintenance')->count();
    @endphp

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('rooms.manager') }}" wire:navigate
                class="mb-2 inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition-colors hover:text-primary">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke daftar kamar
            </a>
            <h1 class="font-poppins text-2xl font-bold text-foreground">Kelola Unit Kamar</h1>
            <p class="mt-1 text-sm text-gray-500">Atur nomor unit untuk kamar {{ $roomName }}.</p>
        </div>
        <span
            class="inline-flex w-fit items-center rounded-full bg-primary/10 px-3 py-1.5 text-sm font-semibold text-primary">
            {{ $roomName }}
        </span>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-primary/20 bg-primary/5 p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-primary/80">Target Stok</p>
                    <h3 class="font-poppins text-2xl font-bold text-primary">{{ $roomStock }}</h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Zm4.5 4.5h6" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-sky-200 bg-sky-50 p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-sky-700">Unit Terdaftar</p>
                    <h3 class="font-poppins text-2xl font-bold text-sky-800">{{ $registeredUnits }}</h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-600 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5M3.75 3.75h16.5v16.5H3.75V3.75Z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-emerald-700">Available</p>
                    <h3 class="font-poppins text-2xl font-bold text-emerald-800">{{ $availableUnits }}</h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 4.5 4.5 10.5-10.5" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-amber-700">Tidak Tersedia</p>
                    <h3 class="font-poppins text-2xl font-bold text-amber-800">{{ $occupiedUnits + $maintenanceUnits }}
                    </h3>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-600 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75V12m0 3.75h.008v.008H12v-.008ZM10.29 3.86 2.82 16.36A1.5 1.5 0 0 0 4.107 18.6h15.786a1.5 1.5 0 0 0 1.287-2.24L13.71 3.86a1.5 1.5 0 0 0-2.574 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_22rem]">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div
                class="flex flex-col gap-2 border-b border-gray-100 p-4 sm:flex-row sm:items-center sm:justify-between lg:p-6">
                <div>
                    <h2 class="font-poppins text-lg font-bold text-foreground">Daftar Unit Kamar</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $registeredUnits }} dari {{ $roomStock }} unit telah
                        terdaftar.</p>
                </div>
                @if ($registeredUnits === $roomStock)
                    <span
                        class="inline-flex w-fit items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">
                        Stok lengkap
                    </span>
                @elseif ($registeredUnits > $roomStock)
                    <span
                        class="inline-flex w-fit items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                        Melebihi stok
                    </span>
                @else
                    <span
                        class="inline-flex w-fit items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                        Kurang {{ $roomStock - $registeredUnits }} unit
                    </span>
                @endif
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">No</th>
                            <th class="px-6 py-3 font-medium">Nomor Unit</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($units as $index => $unit)
                            <tr wire:key="room-unit-{{ $unit->id }}" class="transition-colors hover:bg-gray-50/50">
                                <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Z" />
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-foreground">{{ $unit->room_number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span @class([
                                        'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
                                        'bg-emerald-100 text-emerald-700' => $unit->status === 'available',
                                        'bg-amber-100 text-amber-700' => $unit->status === 'occupied',
                                        'bg-red-100 text-red-700' => $unit->status === 'maintenance',
                                    ])>
                                        {{ ucfirst($unit->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <x-edit-button :item="$unit" :title="'Edit unit'" action="edit" />
                                        <x-delete-button :item="$unit" :title="'Hapus unit'"
                                            confirmDelete="confirmDelete " />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <div
                                        class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5M3.75 3.75h16.5v16.5H3.75V3.75Z" />
                                        </svg>
                                    </div>
                                    <p class="font-medium text-gray-700">Belum ada unit kamar</p>
                                    <p class="mt-1 text-sm text-gray-400">Gunakan form generate untuk membuat nomor
                                        unit.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <aside class="h-fit rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <h2 class="font-poppins text-lg font-bold text-foreground">Tambah Kamar Baru</h2>
            <p class="mt-1 text-sm leading-6 text-gray-500">Masukkan jumlah kamar baru yang ingin dibuat.</p>

            <form wire:submit.prevent="save" class="mt-5 space-y-4">
                <div>
                    <x-input-label for="room_number" value="Nomor Kamar Baru" />
                    <x-text-input id="room_number" type="text" wire:model="room_number" min="1"
                        max="25" class="mt-1" placeholder="Contoh: 10" required />
                    <x-input-error :message="$errors->first('room_number')" />
                </div>


                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="btn-primary flex w-full items-center justify-center gap-2 px-4 py-2.5 text-sm disabled:cursor-not-allowed disabled:opacity-60">
                    <svg wire:loading.remove wire:target="save" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span wire:loading.remove wire:target="save">Buat Kamar</span>
                    <span wire:loading wire:target="save">Memproses...</span>
                </button>
            </form>

            <div class="mt-5 rounded-xl bg-gray-50 p-4 text-xs leading-5 text-gray-500">
                Nomor unit dibuat berurutan menggunakan kode kamar dan nomor tiga digit. Nomor yang sudah ada akan
                dilewati.
            </div>
        </aside>
    </div>

    <x-modal-2 name="manage-room-unit">
        <form wire:submit.prevent="save" class="mt-5 space-y-4">
            <div>

                <x-input-label for="room_number" value="Nomor Kamar Baru" />
                <x-text-input id="room_number" type="text" wire:model="room_number" min="1"
                    max="25" class="mt-1" placeholder="Contoh: 10" required />
                <x-input-error :message="$errors->first('room_number')" />
            </div>
            <div>
                <x-input-label for="status" value="Status Unit" />
                <select id="status" wire:model="status" class="mt-1" @disabled($status === 'occupied')>
                    <option value="available">Available</option>
                    <option value="occupied" disabled>Occupied (otomatis saat check-in)</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                @if ($status === 'occupied')
                    <p class="mt-1 text-xs text-amber-700">Status unit berubah otomatis saat booking check-in/check-out.</p>
                @endif
                <x-input-error :message="$errors->first('status')" />
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="save"
                class="btn-primary flex w-full items-center justify-center gap-2 px-4 py-2.5 text-sm disabled:cursor-not-allowed disabled:opacity-60">
                <svg wire:loading.remove wire:target="save" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                <span wire:loading wire:target="save">Memproses...</span>
            </button>
        </form>
    </x-modal-2>

    <x-modal-2 name="room-unit-delete-confirmation">
        <p>Apakah anda yakin ingin menghapus unit ini?</p>
        <div class="flex justify-end gap-2">
            <button type="button" wire:click="deleteUnit" class="btn-primary">Hapus</button>
            <button type="button" wire:click="$dispatch('close-modal-room-unit-delete-confirmation')"
                class="btn-secondary">
                Batal
            </button>
        </div>
    </x-modal-2>
</div>
