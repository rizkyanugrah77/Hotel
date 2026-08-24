<?php

namespace App\Livewire\Admin;

use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class PromoManager extends Component
{
    use WithPagination;

    public string $code = '';
    public string $name = '';
    public string $discount_type = '';
    public int $discount_value = 0;
    public int $minimum_transaction = 0;
    public ?int $quota = null;
    public int $used_count = 0;
    public string $start_date = '';
    public string $end_date = '';
    public bool $is_active = true;

    public ?int $editingPromoId = null;

    public function save()
    {
        $this->code = strtoupper(trim($this->code));
        $validated = $this->validate($this->Rules($this->editingPromoId), $this->Messages());
        $validated = $this->normaliseDates($validated);

        try {
            if ($this->editingPromoId) {
                $promo = Promo::findOrFail($this->editingPromoId);
                $promo->update($validated);
            } else {
                Promo::create($validated);
            }

            $this->resetForm();
            $this->dispatch('promo-saved', message: 'Promo berhasil ditambahkan.', type: 'success');
        } catch (\Throwable $th) {
            $this->dispatch('promo-error', message: $th->getMessage());
        }
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);

        $this->editingPromoId = $promo->id;
        $this->code = $promo->code;
        $this->name = $promo->name;
        $this->discount_type = $promo->discount_type;
        $this->discount_value = $promo->discount_value;
        $this->minimum_transaction = $promo->minimum_transaction;
        $this->quota = (int) $promo->quota;
        $this->used_count = (int) $promo->used_count;
        $this->start_date = $promo->start_date->format('Y-m-d');
        $this->end_date = $promo->end_date->format('Y-m-d');
        $this->is_active = $promo->is_active;
        $this->resetValidation();

        $this->dispatch('promo-edit');
    }

    // public function update($id)
    // {
    //     $this->code = strtoupper(trim($this->code));
    //     $validated = $this->validate($this->Rules($id), $this->Messages());
    //     $validated = $this->normaliseDates($validated);

    //     try {
    //         $promo = Promo::findOrFail($id);

    //         $promo->update($validated);

    //         $this->resetForm();

    //         $this->dispatch('success', message: 'Promo berhasil diupdate.');
    //     } catch (\Throwable $th) {
    //         $this->dispatch('promo-error', message: $th->getMessage());
    //     }
    // }

    public function delete($id)
    {
        try {
            $promo = Promo::findOrFail($id);

            $promo->delete();

            $this->resetForm();

            $this->dispatch('success', message: 'Promo berhasil dihapus.');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: $th->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'code',
            'name',
            'discount_type',
            'discount_value',
            'minimum_transaction',
            'quota',
            'used_count',
            'start_date',
            'end_date',
            'is_active',
        ]);

        $this->resetValidation();
    }



    public function render()
    {
        $promos = Promo::query()
            ->orderByDesc('is_active')
            ->orderBy('end_date')
            ->paginate(12);

        return view('livewire.layout.promo-manager', [
            'promos' => $promos,
            'promoCount' => Promo::count(),
            'activePromoCount' => Promo::where('is_active', true)->count(),
        ])->layout('layouts.app');
    }

    private function normaliseDates(array $validated): array
    {
        $validated['start_date'] = Carbon::parse($validated['start_date'])->startOfDay();
        $validated['end_date'] = Carbon::parse($validated['end_date'])->endOfDay();

        return $validated;
    }

    public function Rules(?int $editingPromoId)
    {
        return [
            'code' => ['string', 'required', Rule::unique('promos', 'code')->ignore($editingPromoId)],
            'name' => 'string|required',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'integer|required|min:1',
            'minimum_transaction' => 'integer|required|min:0',
            'quota' => 'integer|nullable|min:1',
            'used_count' => [
                'integer',
                'nullable',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->quota !== null && (int) $value > $this->quota) {
                        $fail('Jumlah penggunaan tidak boleh melebihi kuota.');
                    }
                },
            ],
            'start_date' => 'date|required|before_or_equal:end_date',
            'end_date' => 'date|required|after_or_equal:start_date',
            'is_active' => 'boolean|required',
        ];
    }

    public function Messages()
    {
        return [
            'code.required' => 'Kode promo wajib diisi.',
            'code.unique' => 'Kode promo sudah digunakan.',
            'name.required' => 'Nama promo wajib diisi.',
            'discount_type.required' => 'Jenis diskon wajib diisi.',
            'discount_value.required' => 'Nilai diskon wajib diisi.',
            'minimum_transaction.required' => 'Nilai transaksi minimum wajib diisi.',
            'quota.required' => 'Kuota wajib diisi.',
            'used_count.required' => 'Jumlah penggunaan wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal berakhir wajib diisi.',
            'is_active.required' => 'Status promo wajib diisi.',
        ];
    }
}
