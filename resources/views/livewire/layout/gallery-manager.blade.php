<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type = 'success') {
        this.toast.message = message;
        this.toast.type = type;
        this.toast.show = true;
        window.setTimeout(() => this.toast.show = false, 3000);
    }
}"
    x-on:gallery-saved.window="showToast($event.detail.message, $event.detail.type); $dispatch('close-modal', 'manage-gallery')"
    x-on:gallery-deleted.window="showToast($event.detail.message, $event.detail.type); $dispatch('close-modal', 'gallery-delete-confirmation')"
    x-on:gallery-error.window="showToast($event.detail.message, $event.detail.type); $dispatch('close-modal', 'manage-gallery')"
    x-on:gallery-editing.window="$dispatch('open-modal', 'manage-gallery')"
    x-on:gallery-delete-confirmation.window="$dispatch('open-modal', 'gallery-delete-confirmation')"
    class="min-w-0 h-full flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

    <x-toast />
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Gambar</p>
                    <h3 class="text-2xl font-poppins font-bold text-foreground" id="kpiTotal">
                        {{ $galleryStats['total'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 font-medium" id="kpiTotalSub">Di seluruh kamar</p>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Featured</p>
                    <h3 class="text-2xl font-poppins font-bold text-accent-600" id="kpiFeatured">
                        {{ $galleryStats['featured'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-accent/10 text-accent-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-accent-600 font-medium" id="kpiFeaturedSub">Gambar unggulan</p>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Rooms Linked</p>
                    <h3 class="text-2xl font-poppins font-bold text-blue-600" id="kpiRooms">
                        {{ $galleryStats['rooms'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-blue-600 font-medium" id="kpiRoomsSub">Kamar terhubung</p>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Non-Featured</p>
                    <h3 class="text-2xl font-poppins font-bold text-gray-600" id="kpiRegular">
                        {{ $galleryStats['regular'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-gray-100 text-gray-500 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 font-medium">Gambar reguler</p>
        </div>
    </div>

    <!-- Action Bar & Table -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden mb-8 grid grid-cols-1">
        <div
            class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-poppins font-bold text-lg">Daftar Gallery</h2>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari gambar..."
                        class="input pl-10 pr-4 py-2 text-sm w-64" />
                </div>
                <select id="filterFeatured" class="input py-2 text-sm w-40">
                    <option value="">Semua Status</option>
                    <option value="true">Featured</option>
                    <option value="false">Non-Featured</option>
                </select>
                <select id="filterRoom" class="input py-2 text-sm w-44">
                    <option value="">Semua Room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
                <button @click="$dispatch('open-modal', 'manage-gallery'); $wire.resetForm()"
                    class="btn-primary text-sm px-4 py-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Gambar
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap" id="galleriesTable">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="py-3 px-6 font-medium">No</th>
                        <th class="py-3 px-6 font-medium">Preview</th>
                        <th class="py-3 px-6 font-medium">Room</th>
                        <th class="py-3 px-6 font-medium">Image Path</th>
                        <th class="py-3 px-6 font-medium">Caption</th>
                        <th class="py-3 px-6 font-medium">Featured</th>
                        <th class="py-3 px-6 font-medium text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($galleries as $gallery)
                        <tr>
                            <td class="py-3 px-6">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6"><img src="{{ asset('assets/img/gallery/' . $gallery->image) }}"
                                    alt="{{ $gallery->caption }}" class="w-20 h-20 object-cover rounded-lg"></td>
                            <td class="py-3 px-6">{{ $gallery->room->name }}</td>
                            <td class="py-3 px-6">{{ $gallery->image_path }}</td>
                            <td class="py-3 px-6">{{ $gallery->caption }}</td>
                            <td class="py-3 px-6">
                                @if ($gallery->is_featured)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        No
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex flex-row justify-center items-center gap-2">
                                    <x-edit-button :item="$gallery" action="edit" />

                                    <x-delete-button :item="$gallery" confirmDelete="confirmDelete" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reports Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Gallery per Room -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <h2 class="font-poppins font-bold text-lg mb-6">Gambar per Room</h2>
            <div class="space-y-4" id="reportByRoom">
            </div>
        </div>

        <!-- Featured Statistics -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <h2 class="font-poppins font-bold text-lg mb-6">Statistik Featured</h2>
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Total Featured</p>
                    <p class="text-xl font-poppins font-bold text-accent-700" id="statFeatured">0</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Total Non-Featured</p>
                    <p class="text-xl font-poppins font-bold text-foreground" id="statNonFeatured">0</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Rasio Featured</p>
                    <p class="text-xl font-poppins font-bold text-primary" id="statRatio">0%</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">Room Paling Banyak Gambar</p>
                    <p class="text-xl font-poppins font-bold text-blue-600" id="statTopRoom">-</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <h2 class="font-poppins font-bold text-lg mb-6">Status Galeri</h2>
            <div class="space-y-4" id="statusReport">
            </div>
            <div class="mt-6 pt-6 border-t border-gray-100">
                <h3 class="text-sm font-medium text-gray-600 mb-3">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <button onclick="openModal()"
                        class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Gambar
                    </button>
                    <button onclick="exportReport()"
                        class="p-3 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors flex flex-col items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Tambah/Edit --}}
    <x-modal-2 name="manage-gallery" :title="$editingGalleryId ? 'Edit Gambar' : 'Tambah Gambar'">
        <form wire:submit="save">
            <!-- Room ID -->
            <div class="mb-4">
                <label class="input-label">Room <span class="text-red-500">*</span></label>
                <select wire:model="room_id" class="input" required>
                    <option value="">Pilih Room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
                <x-input-error name="room_id" />
            </div>

            <!-- Image Path -->
            <div class="mb-4">

                <x-input-label for="gallery-image" class="input-label">Gambar Kamar @if (!$editingGalleryId)
                        <span class="text-red-500">*</span>
                    @endif
                </x-input-label>
                <span class="t9+69` qwertgc/+ext-sm text-red-500">Ukuran maksimal foto 2MB dan file JPG, JPEG, atau
                    PNG</span>

                <input id="gallery-image" type="file" wire:model.live="image" class="input" accept="image/*">

                <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-2">
                    Mengupload gambar...
                </div>

                @if (!$editingGalleryId)
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                            class="mt-2 w-full h-48 object-cover rounded-xl">
                    @endif
                @endif
                <x-input-error name="image" />
            </div>

            <!-- Caption -->
            <div class="mb-4">
                <label class="input-label">Caption <span class="text-red-500">*</span></label>
                <textarea class="input" rows="3" placeholder="Deskripsi singkat gambar..." wire:model="caption" required></textarea>
                <x-input-error name="caption" />
            </div>

            <!-- Is Featured -->
            <div class="mb-4">
                <label class="input-label">Featured</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="galleryIsFeatured" class="sr-only peer"
                            wire:model="is_featured" />
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                        </div>
                    </label>
                    <span class="text-sm text-gray-600" id="featuredLabel">Non-Featured</span>
                </div>
                <x-input-error name="is_featured" />
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" class="btn-primary text-sm px-5 py-2.5">Simpan Gambar</button>
            </div>
        </form>
    </x-modal-2>

    {{-- Delete --}}
    <x-modal-2 name="gallery-delete-confirmation">
        <h2 class="text-lg font-poppins font-semibold mb-4">Konfirmasi Hapus</h2>
        <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus gambar ini?</p>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
            <button @click="$dispatch('close-modal', 'gallery-delete-confirmation')"
                class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
            <button wire:click="delete"
                class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition-colors">
                <span wire:loading.remove wire:target="delete">Hapus</span>
                <span wire:loading wire:target="delete">Menghapus...</span>
            </button>
        </div>
    </x-modal-2>
</div>a
