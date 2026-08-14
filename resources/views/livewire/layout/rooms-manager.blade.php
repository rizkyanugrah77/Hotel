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

    <div class=" bg-white border border-gray-100 shadow-sm rounded-2xl grid grid-cols-1 ">
        <div
            class="p-3 lg:p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <h2 class="font-poppins font-bold text-lg">Daftar Kamar</h2>
            <div class="flex flex-col sm:flex-row w-full lg:w-auto items-stretch sm:items-center gap-3">
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Cari nama kamar..."
                    class="input py-2 text-sm sm:w-32 xl:w-60 ">
                <select wire:model.live="filterStatus" class="input py-2 text-sm sm:w-40">
                    <option value="">Semua Status</option>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <button @click="$dispatch('open-modal', 'manage-room'); $wire.resetForm()"
                    class="btn-primary text-sm px-4 py-2 whitespace-nowrap">
                    Tambah Kamar
                </button>
            </div>
        </div>

        <div class="w-full overflow-auto">
            <table class=" w-full text-left text-sm whitespace-nowrap ">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="py-3 px-6 font-medium">No</th>
                        <th class="py-3 px-6 font-medium">Gambar</th>
                        <th class="py-3 px-6 font-medium">Nama</th>
                        <th class="py-3 px-6 font-medium">Slug</th>
                        <th class="py-3 px-6 font-medium">Ukuran</th>
                        <th class="py-3 px-6 font-medium">Tipe Bed</th>
                        <th class="py-3 px-6 font-medium">Kapasitas</th>
                        <th class="py-3 px-6 font-medium">Harga/Malam</th>
                        <th class="py-3 px-6 font-medium">Fasilitas</th>
                        <th class="py-3 px-6 font-medium">Status</th>
                        <th class="py-3 px-6 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rooms as $index => $room)
                        <tr wire:key="room-{{ $room->id }}">
                            <td class="py-3 px-6 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-6">
                                @if ($room->image)
                                    <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}"
                                        class="h-12 w-16 rounded-lg object-cover">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 font-medium">{{ $room->name }}</td>
                            <td class="py-3 px-6">{{ $room->slug }}</td>
                            <td class="py-3 px-6">{{ $room->size }} m&sup2;</td>
                            <td class="py-3 px-6">{{ $room->bed_type }}</td>
                            <td class="py-3 px-6">{{ $room->capacity }} orang</td>
                            <td class="py-3 px-6">Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-6 max-w-52">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($room->facilities as $facility)
                                        <span
                                            class="inline-flex w-fit items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-100 text-emerald-700 [&>svg]:w-4 [&>svg]:h-4 [&>svg]:text-emerald-700 [&>svg]:mr-1 [&>svg]:fill-current">
                                            {!! $facility->icon !!}
                                            {{ $facility->name }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-3 px-6">
                                <span @class([
                                    'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
                                    'bg-emerald-100 text-emerald-700' => $room->status === 'available',
                                    'bg-amber-100 text-amber-700' => $room->status === 'occupied',
                                    'bg-red-100 text-red-700' => $room->status === 'maintenance',
                                ])>
                                    {{ ucfirst($room->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <x-edit-button :item="$room" action="edit" />
                                    <x-delete-button :item="$room" confirmDelete="confirmDelete " />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-gray-500">
                                Belum ada kamar. Klik &ldquo;Tambah Kamar&rdquo; untuk menambahkan kamar baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-gray-50 rounded-b-xl">

            {{ $rooms->links() }}
        </div>
    </div>

    {{-- modal tambah --}}
    <x-modal-2 name="manage-room" :title="$editingRoomId ? 'Edit Kamar' : 'Tambah Kamar'">
        <form wire:submit="save">
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
            <button @click="$dispatch('close-modal', 'delete-room')"
                class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
            <x-danger-button wire:click="delete" wire:loading.attr="disabled" type="button">
                <span wire:loading.remove wire:target="delete">Hapus</span>
                <span wire:loading wire:target="delete">Menghapus...</span>
            </x-danger-button>
        </div>
    </x-modal-2>

</div>
