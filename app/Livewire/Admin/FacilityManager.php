<?php

namespace App\Livewire\Admin;

use App\Models\Facility;
use Livewire\Component;
use Livewire\WithPagination;

class FacilityManager extends Component
{
    use WithPagination;

    public string $name = '';

    public string $icon = '';

    public string $description = '';

    public $search = '';

    public $perPage = 5;

    public ?int $editingFacilityId = null;

    public ?int $facilityToDelete = null;

    public function save(): void
    {
        $this->validate();

        $isEditing = (bool) $this->editingFacilityId;
        $attributes = [
            'name' => $this->name,
            'icon' => $this->icon,
            'description' => $this->description,
        ];

        try {
            if ($isEditing) {
                Facility::findOrFail($this->editingFacilityId)->update($attributes);
            } else {
                Facility::create($attributes);
            }
            $this->resetForm();

            $this->dispatch(
                'facility-saved',
                message: $isEditing ? 'Fasilitas berhasil diperbarui.' : 'Fasilitas berhasil ditambahkan.',
                type: $isEditing ? 'success' : 'success'
            );
        } catch (\Throwable $th) {
            $this->dispatch('facility-error', message: $th->getMessage(), type: 'error');
        }
    }

    public function edit(int $facilityId): void
    {
        $facility = Facility::findOrFail($facilityId);

        $this->editingFacilityId = $facility->id;
        $this->name = $facility->name;
        $this->icon = $facility->icon ?? '';
        $this->description = $facility->description ?? '';
        $this->resetValidation();

        $this->dispatch('facility-editing');
    }

    public function confirmDelete(int $facilityId): void
    {
        $this->facilityToDelete = Facility::findOrFail($facilityId)->id;

        $this->dispatch('facility-delete-confirmation');
    }

    public function delete(): void
    {
        abort_unless($this->facilityToDelete, 404);

        Facility::findOrFail($this->facilityToDelete)->delete();
        $this->facilityToDelete = null;

        $this->dispatch('facility-deleted', message: 'Fasilitas berhasil dihapus.', type: 'success');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'description', 'icon']);
        $this->editingFacilityId = null;
        $this->resetValidation();
    }

    public function render()
    {
        $facilities = Facility::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->paginate($this->perPage);

        return view('livewire.layout.facility-manager', [
            'facilities' => $facilities,
            'facilityStats' => [
                'total' => Facility::query()->count(),
                'active' => Facility::query()->count(), // all facilities are active for now
                'maintenance' => 0,
            ],
        ])->layout('layouts.app');
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
