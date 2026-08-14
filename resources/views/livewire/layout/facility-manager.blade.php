<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.show = true;
        this.toast.type = type;
        window.setTimeout(() => this.toast.show = false, 3000);
    }
}"
    x-on:facility-saved.window="$dispatch('close-modal', 'manage-facility'); showToast($event.detail.message, $event.detail.type)"
    x-on:facility-deleted.window="$dispatch('close-modal', 'delete-facility'); showToast($event.detail.message, $event.detail.type)"
    x-on:facility-error.window="showToast($event.detail.message, $event.detail.type); $dispatch('close-modal', 'manage-facility')"
    x-on:facility-editing.window="$dispatch('open-modal', 'manage-facility')"
    x-on:facility-delete-confirmation.window="$dispatch('open-modal', 'delete-facility')">

    <div class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        {{-- Toast Notification --}}
        <x-toast />

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Fasilitas</p>
                        <h3 class="text-2xl font-poppins font-bold text-foreground">{{ $facilityStats['total'] }}</h3>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Aktif</p>
                        <h3 class="text-2xl font-poppins font-bold text-emerald-600">{{ $facilityStats['active'] }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Maintenance</p>
                        <h3 class="text-2xl font-poppins font-bold text-red-600">{{ $facilityStats['maintenance'] }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Bar & Table --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden grid grid-cols-1 mb-8">
            <div
                class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="font-poppins font-bold text-lg">Daftar Fasilitas</h2>
                <div class="flex flex-col sm:flex-row w-full lg:w-auto items-stretch sm:items-center gap-3">
                    <div class="relative w-full sm:w-auto">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari fasilitas..."
                            class="input pl-10 pr-4 py-2 text-sm sm:w-40 w-full" />
                    </div>
                    <button @click="$dispatch('open-modal', 'manage-facility'); $wire.resetForm()"
                        class="btn-primary flex justify-center items-center gap-2 text-sm px-4 py-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Fasilitas
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="py-3 px-6 font-medium">No</th>
                            <th class="py-3 px-6 font-medium">Ikon</th>
                            <th class="py-3 px-6 font-medium">Nama Fasilitas</th>
                            <th class="py-3 px-6 font-medium">Deskripsi Singkat</th>
                            <th class="py-3 px-6 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($facilities as $index => $facility)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-6 text-gray-500">{{ $facilities->firstItem() + $index }}</td>
                                <td class="py-3 px-6">
                                    @if ($facility->icon)
                                        <div
                                            class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                                            {!! $facility->icon !!}
                                        </div>
                                    @else
                                        <div
                                            class="w-10 h-10 bg-gray-100 text-gray-400 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-6 font-medium text-foreground">{{ $facility->name }}</td>
                                <td class="py-3 px-6 text-gray-500 max-w-xs truncate">
                                    {{ Str::limit($facility->description, 60) }}</td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $facility->id }})"
                                            class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $facility->id }})"
                                            class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400">Tidak ada fasilitas
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($facilities->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $facilities->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Create/Edit Facility Modal --}}
    <x-modal-2 name="manage-facility" :title="$editingFacilityId ? 'Edit Fasilitas' : 'Tambah Fasilitas'">
        <form wire:submit="save">
            <div class="mb-4">
                <x-input-label for="name" value="Nama Fasilitas" :required="true" />
                <input type="text" wire:model="name" class="input" placeholder="e.g. Kolam Renang" />
                <x-input-error :message="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="icon" value="Ikon SVG" :required="true" />
                <textarea wire:model="icon" class="input font-mono text-xs" rows="3" placeholder="<svg>...</svg>"></textarea>
                <x-input-error :message="$errors->get('icon')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="description" value="Deskripsi" :required="true" />
                <textarea wire:model="description" class="input" rows="4" placeholder="Deskripsi mengenai fasilitas..."></textarea>
                <x-input-error :message="$errors->get('description')" class="mt-2" />
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" @click="$dispatch('close-modal', 'manage-facility'); $wire.resetForm()"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                <x-primary-button wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove
                        wire:target="save">{{ $editingFacilityId ? 'Edit Fasilitas' : 'Tambah Fasilitas' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-primary-button>
            </div>
        </form>
    </x-modal-2>

    {{-- Delete Confirmation Modal --}}
    <x-modal-2 name="delete-facility" title="Hapus Fasilitas?">
        <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus fasilitas ini?</p>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
            <button @click="$dispatch('close-modal', 'delete-facility')"
                class="btn-second text-sm px-5 py-2.5">Batal</button>
            <x-danger-button wire:click="delete" type="button">
                <span wire:loading.remove wire:target="delete">Hapus</span>
                <span wire:loading wire:target="delete">Menghapus...</span>
            </x-danger-button>
        </div>
    </x-modal-2>
</div>
