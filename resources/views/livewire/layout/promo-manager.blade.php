<div x-data="{
    toast: { show: false, message: '', type: 'success' },
    showToast(message, type) {
        this.toast.message = message;
        this.toast.type = type;
        this.toast.show = true;
        window.setTimeout(() => this.toast.show = false, 3000);
    }
}" x-on:open-modal-edit-promo.window="$dispatch('open-modal', 'manage-promo')"
    x-on:show-toast.window="showToast($event.detail.message, $event.detail.type)"
    x-on:promo-error.window="showToast($event.detail.message, 'error')"
    x-on:promo-saved.window="$dispatch('close-modal', 'manage-promo'), $dispatch('show-toast', $event.detail.message, $event.detail.type)"
    x-on:promo-deleted.window="$dispatch('close-modal', 'manage-promo'), $dispatch('show-toast', $event.detail.message, 'success')"
    x-on:promo-deleted.window="$dispatch('promo-delete-confirmation')"
    x-on:promo-deleted-error.window="$dispatch('show-toast', $event.detail.message, 'error')"
    class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
    <x-toast />
    <div class="mb-5 flex flex-col gap-3 sm:mb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Finance</p>
            <h1 class="mt-1 font-poppins text-xl font-bold text-foreground sm:text-2xl">Promo Manager</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola dan pantau penawaran promo hotel.</p>
        </div>
        <div class="grid grid-cols-2 gap-2 sm:flex">
            <div class="rounded-xl border border-gray-100 bg-white px-3 py-2 shadow-sm">
                <p class="text-xs text-gray-500">Total promo</p>
                <p class="font-poppins text-lg font-bold text-gray-900">{{ $promoCount }}</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2">
                <p class="text-xs text-emerald-700">Aktif</p>
                <p class="font-poppins text-lg font-bold text-emerald-700">{{ $activePromoCount }}</p>
            </div>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-4 sm:px-5">
            <div>
                <h2 class="font-poppins text-base font-bold text-gray-900">Daftar Promo</h2>
                <p class="mt-0.5 text-xs text-gray-500">{{ $promos->total() }} promo terdaftar</p>
            </div>

            <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
            </svg>
        </div>

        <div class="border-t border-gray-100 px-4 py-3 sm:px-5">
            <div>
                <button @click="$dispatch('open-modal', 'manage-promo')" wire:loading.attr="disabled"
                    class="rounded-xl bg-primary px-4 py-2 text-sm font-medium text-white">
                    Tambah Promo
                </button>
            </div>
        </div>

        <div class="divide-y divide-gray-100 md:hidden">
            @forelse ($promos as $promo)
                @php
                    $isActive = $promo->is_active;
                    $discount =
                        $promo->discount_type === 'percentage'
                            ? number_format((float) $promo->discount_value, 0, ',', '.') . '%'
                            : 'Rp' . number_format((float) $promo->discount_value, 0, ',', '.');
                @endphp
                <article wire:key="promo-mobile-{{ $promo->id }}" class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-gray-900">{{ $promo->name }}</p>
                            <code
                                class="mt-1 inline-block rounded bg-gray-100 px-2 py-0.5 text-xs font-semibold tracking-wide text-gray-700">{{ $promo->code }}</code>
                        </div>
                        <span @class([
                            'shrink-0 rounded-full px-2 py-1 text-xs font-medium',
                            'bg-emerald-50 text-emerald-700' => $isActive,
                            'bg-gray-100 text-gray-600' => !$isActive,
                        ])>{{ $isActive ? 'Aktif' : 'Nonaktif' }}</span>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2 rounded-xl bg-gray-50 p-3 text-sm">
                        <div>
                            <p class="text-xs text-gray-500">Diskon</p>
                            <p class="mt-0.5 font-semibold text-primary">{{ $discount }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Min. transaksi</p>
                            <p class="mt-0.5 font-medium text-gray-800">
                                Rp{{ number_format((float) $promo->minimum_transaction, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Penggunaan</p>
                            <p class="mt-0.5 font-medium text-gray-800">{{ $promo->used_count }} /
                                {{ $promo->quota ?? 'Tanpa batas' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Jenis</p>
                            <p class="mt-0.5 font-medium text-gray-800">
                                {{ $promo->discount_type === 'percentage' ? 'Persentase' : 'Nominal' }}</p>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>{{ \Illuminate\Support\Carbon::parse($promo->start_date)->format('d M Y, H:i') }} -
                            {{ \Illuminate\Support\Carbon::parse($promo->end_date)->format('d M Y, H:i') }}</span>
                    </div>
                </article>
            @empty
                <p class="px-4 py-12 text-center text-sm text-gray-500">Belum ada promo.</p>
            @endforelse
        </div>

        <div class="hidden overflow-x-auto md:block">

            <table class="w-full min-w-[1100px] text-left text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500">
                    <tr>
                        <th class="px-4 py-3 font-medium">Promo</th>
                        <th class="px-4 py-3 font-medium">Diskon</th>
                        <th class="px-4 py-3 font-medium">Min. Transaksi</th>
                        <th class="px-4 py-3 font-medium">Kuota</th>
                        <th class="px-4 py-3 font-medium">Periode</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($promos as $promo)
                        @php
                            $isActive = $promo->is_active;
                            $discount =
                                $promo->discount_type === 'percentage'
                                    ? number_format((float) $promo->discount_value, 0, ',', '.') . '%'
                                    : 'Rp' . number_format((float) $promo->discount_value, 0, ',', '.');
                        @endphp
                        <tr wire:key="promo-desktop-{{ $promo->id }}" class="hover:bg-gray-50/70">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">{{ $promo->name }}</p>
                                <code
                                    class="mt-1 inline-block rounded bg-gray-100 px-1.5 py-0.5 text-xs font-semibold text-gray-600">{{ $promo->code }}</code>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-primary">{{ $discount }}</p>
                                <p class="mt-0.5 text-xs text-gray-500">
                                    {{ $promo->discount_type === 'percentage' ? 'Persentase' : 'Nominal' }}</p>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-700">
                                Rp{{ number_format((float) $promo->minimum_transaction, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ $promo->used_count }} /
                                    {{ $promo->quota ?? 'Tanpa batas' }}</p>
                                <p class="mt-0.5 text-xs text-gray-500">Digunakan / kuota</p>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-600">
                                <p>{{ \Illuminate\Support\Carbon::parse($promo->start_date)->format('d M Y, H:i') }}
                                </p>
                                <p class="mt-1">
                                    {{ \Illuminate\Support\Carbon::parse($promo->end_date)->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'inline-flex rounded-full px-2 py-1 text-xs font-medium',
                                    'bg-emerald-50 text-emerald-700' => $isActive,
                                    'bg-gray-100 text-gray-600' => !$isActive,
                                ])>{{ $isActive ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">Belum ada promo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($promos->hasPages())
            <div class="border-t border-gray-100 px-4 py-3 sm:px-5">
                {{ $promos->links() }}
            </div>
        @endif
    </section>

    <x-modal-2 name="manage-promo" title="Tambah Promo">
        <form wire:submit="save">
            <div class="space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="promo-code" value="Kode Promo" />
                        <x-text-input id="promo-code" wire:model="code" class="input mt-1" placeholder="Contoh: HEMAT10" required />
                        <x-input-error :message="$errors->get('code')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="promo-name" value="Nama Promo" />
                        <x-text-input id="promo-name" wire:model="name" class="input mt-1" placeholder="Contoh: Promo Liburan" required />
                        <x-input-error :message="$errors->get('name')" class="mt-2" />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="promo-discount-type" value="Jenis Diskon" />
                        <select id="promo-discount-type" wire:model="discount_type" class="input mt-1" required>
                            <option value="">Pilih jenis diskon</option>
                            <option value="percentage">Persentase</option>
                            <option value="fixed">Nominal</option>
                        </select>
                        <x-input-error :message="$errors->get('discount_type')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="promo-discount-value" value="Nilai Diskon" />
                        <x-text-input id="promo-discount-value" wire:model="discount_value" type="number" min="0" class="input mt-1" placeholder="0" required />
                        <x-input-error :message="$errors->get('discount_value')" class="mt-2" />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="promo-minimum-transaction" value="Nilai Transaksi Minimum" />
                        <x-text-input id="promo-minimum-transaction" wire:model="minimum_transaction" type="number" min="0" class="input mt-1" placeholder="0" required />
                        <x-input-error :message="$errors->get('minimum_transaction')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="promo-quota" value="Kuota" />
                        <x-text-input id="promo-quota" wire:model="quota" type="number" min="0" class="input mt-1" placeholder="Kosongkan untuk tanpa batas" />
                        <x-input-error :message="$errors->get('quota')" class="mt-2" />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="promo-used-count" value="Jumlah Penggunaan" />
                        <x-text-input id="promo-used-count" wire:model="used_count" type="number" min="0" class="input mt-1" placeholder="0" required />
                        <x-input-error :message="$errors->get('used_count')" class="mt-2" />
                    </div>
                    <div class="flex items-end">
                        <div class="w-full rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <x-input-label for="promo-is-active" value="Status Promo" />
                                    <p class="mt-0.5 text-xs text-gray-500">Promo dapat digunakan saat aktif.</p>
                                </div>
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input id="promo-is-active" type="checkbox" wire:model="is_active" class="peer sr-only" />
                                    <span class="h-6 w-11 rounded-full bg-gray-200 transition-colors peer-checked:bg-primary peer-focus:ring-4 peer-focus:ring-primary/20 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-transform peer-checked:after:translate-x-full"></span>
                                </label>
                            </div>
                            <x-input-error :message="$errors->get('is_active')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="promo-start-date" value="Tanggal Mulai" />
                        <x-text-input id="promo-start-date" wire:model="start_date" type="date" class="input mt-1" required />
                        <x-input-error :message="$errors->get('start_date')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="promo-end-date" value="Tanggal Berakhir" />
                        <x-text-input id="promo-end-date" wire:model="end_date" type="date" class="input mt-1" required />
                        <x-input-error :message="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-4">
                <button type="button" @click="$dispatch('close-modal', 'manage-promo'); $wire.resetForm()"
                    class="rounded-xl bg-gray-100 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200">
                    Batal
                </button>
                <x-primary-button wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">Tambah Promo</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-primary-button>
            </div>
        </form>
    </x-modal-2>
</div>
