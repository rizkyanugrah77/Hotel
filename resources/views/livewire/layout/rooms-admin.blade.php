<div x-data="{
    showRoomModal: false,
    toast: { show: false, message: '' },
    openRoomModal() {
        this.showRoomModal = true;
        document.body.classList.add('overflow-hidden');
    },
    closeRoomModal() {
        this.showRoomModal = false;
        document.body.classList.remove('overflow-hidden');
    },
    showToast(message) {
        this.toast.message = message;
        this.toast.show = true;
        window.setTimeout(() => this.toast.show = false, 3000);
    }
}" x-on:room-saved.window="closeRoomModal(); showToast($event.detail.message)"
    class="flex-1 overflow-y-auto p-8">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <p class="text-sm text-gray-500 mb-1">Total Kamar</p>
            <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $roomStats['total'] }}</h3>
        </div>
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <p class="text-sm text-gray-500 mb-1">Available</p>
            <h3 class="text-2xl font-poppins font-bold text-emerald-600">{{ $roomStats['available'] }}</h3>
        </div>
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <p class="text-sm text-gray-500 mb-1">Occupied</p>
            <h3 class="text-2xl font-poppins font-bold text-amber-600">{{ $roomStats['occupied'] }}</h3>
        </div>
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <p class="text-sm text-gray-500 mb-1">Maintenance</p>
            <h3 class="text-2xl font-poppins font-bold text-red-600">{{ $roomStats['maintenance'] }}</h3>
        </div>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        <div
            class="p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <h2 class="font-poppins font-bold text-lg">Daftar Kamar</h2>
            <div class="flex flex-col sm:flex-row w-full lg:w-auto items-stretch sm:items-center gap-3">
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Cari nama kamar..."
                    class="input py-2 text-sm sm:w-64">
                <select wire:model.live="filterStatus" class="input py-2 text-sm sm:w-40">
                    <option value="">Semua Status</option>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <button type="button" wire:click="resetForm" @click="openRoomModal()"
                    class="btn-primary text-sm px-4 py-2 whitespace-nowrap">
                    Tambah Kamar
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
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
                        <th class="py-3 px-6 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rooms as $index => $room)
                        <tr wire:key="room-{{ $room->id }}">
                            <td class="py-3 px-6 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-6">
                                @if ($room->image)
                                    <img src="{{ asset('storage/assets/img/rooms/' . $room->image) }}"
                                        class="w-16 h-12 object-cover rounded-lg">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 font-medium">{{ $room->name }}</td>
                            <td class="py-3 px-6">{{ $room->slug }}</td>
                            <td class="py-3 px-6">{{ $room->size }} m²</td>
                            <td class="py-3 px-6">{{ $room->bed_type }}</td>
                            <td class="py-3 px-6">{{ $room->capacity }} orang</td>
                            <td class="py-3 px-6">Rp{{ number_format($room->price, 0, ',', '.') }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-gray-500">
                                Belum ada kamar. Klik “Tambah Kamar” untuk menambahkan kamar baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="showRoomModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @keydown.escape.window="closeRoomModal()">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeRoomModal()"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" @click.stop>
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-lg font-bold">Tambah Kamar</h3>
                <button type="button" @click="closeRoomModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100"
                    aria-label="Tutup">×</button>
            </div>

            <form wire:submit="save" class="overflow-y-auto p-6 flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="room-name" class="input-label">Nama <span class="text-red-500">*</span></label>
                        <input id="room-name" type="text" wire:model="name" class="input"
                            placeholder="Contoh: Deluxe Lake View" required>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="room-bed-type" class="input-label">Tipe Tempat Tidur <span
                                class="text-red-500">*</span></label>
                        <select id="room-bed-type" wire:model="bed_type" class="input" required>
                            <option value="">Pilih tipe tempat tidur</option>
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                            <option value="Twin">Twin</option>
                            <option value="Queen">Queen</option>
                            <option value="King">King</option>
                            <option value="Twin Double">Twin Double</option>
                        </select>
                        @error('bed_type')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="room-description" class="input-label">Deskripsi <span
                            class="text-red-500">*</span></label>
                    <textarea id="room-description" wire:model="description" class="input" rows="3"
                        placeholder="Deskripsi singkat mengenai kamar..." required></textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="room-size" class="input-label">Ukuran (m²) <span
                                class="text-red-500">*</span></label>
                        <input id="room-size" type="number" wire:model="size" class="input" min="1"
                            required>
                        @error('size')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="room-capacity" class="input-label">Kapasitas (orang) <span
                                class="text-red-500">*</span></label>
                        <input id="room-capacity" type="number" wire:model="capacity" class="input"
                            min="1" required>
                        @error('capacity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="room-price" class="input-label">Harga per Malam (Rp) <span
                                class="text-red-500">*</span></label>
                        <input id="room-price" type="number" wire:model="price" class="input" min="0"
                            required>
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="room-status" class="input-label">Status <span
                                class="text-red-500">*</span></label>
                        <select id="room-status" wire:model="status" class="input" required>
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="room-image" class="input-label">Gambar Kamar</label>
                    <input id="room-image" type="file" wire:model="image" class="input" accept="image/*">

                    <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-2">
                        Mengupload gambar...
                    </div>

                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" @click="closeRoomModal()"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="save"
                        class="btn-primary text-sm px-5 py-2.5">
                        <span wire:loading.remove wire:target="save">Simpan Kamar</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="toast.show" x-cloak class="fixed top-6 right-6 z-[80]">
        <div class="px-5 py-3 bg-white border border-emerald-200 shadow-lg rounded-xl text-sm font-medium text-emerald-700"
            x-text="toast.message"></div>
    </div>
</div>
