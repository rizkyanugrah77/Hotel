<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\RoomUnit;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RoomUnitAdmin extends Component
{
    public ?int $roomUnitId = null;
    public ?int $roomId = null;
    public string $roomName = '';
    public string $roomSlug = '';
    public int $roomStock = 0;
    public string $room_number = '';
    public string $status = 'available';

    public function mount(string $roomSlug): void
    {
        $room = Room::where('slug', $roomSlug)->firstOrFail();
        $this->roomId = $room->id;
        $this->roomName = $room->name;
        $this->roomStock = $room->room_stock;
    }

    public function save(): void
    {
        $validated = $this->validate();
        $isEditing = (bool) $this->roomUnitId;

        $validated['room_id'] = $this->roomId;
        $validated['room_number'] =  $this->room_number;
        $validated['status'] = $this->status;

        if ($isEditing) {
            RoomUnit::findOrFail($this->roomUnitId)->update($validated);
        } else {
            RoomUnit::create($validated);
        }

        $this->reset(['roomUnitId', 'room_number', 'status']);
        $this->dispatch(
            'room-unit-saved',
            message: $isEditing ? 'Nomor unit berhasil diupdate.' : 'Nomor unit berhasil dibuat.',
            type: 'success'
        );
    }

    public function edit(int $roomUnitId)
    {
        $roomUnit = RoomUnit::findOrFail($roomUnitId);
        $this->roomUnitId = $roomUnit->id;
        $this->room_number = $roomUnit->room_number;
        $this->status = $roomUnit->status;
        $this->resetValidation();

        $this->dispatch('open-modal-edit-unit');
    }

    // public function confirmDelete(int $id): void
    // {
    //     $this->roomUnitId = $id;
    //     $this->dispatch('room-unit-delete-confirmation');
    // }

    public function deleteUnit(): void
    {
        $unit = RoomUnit::findOrFail($this->roomUnitId);
        // TODO: Check if unit is occupied
        $unit->delete();
        $this->dispatch('success', message: 'Unit berhasil dihapus.');
    }

    public function render()
    {
        $units = RoomUnit::where('room_id', $this->roomId)
            ->orderBy('room_number')
            ->get();

        return view('livewire.layout.room-units-manager', [
            'units' => $units,
            'roomStock' => $this->roomStock,
        ])->layout('layouts.app');
    }

    public function rules(): array
    {
        return [
            'room_number' => [
                'required',
                'string',
                'min:1',
                'max:25',
                Rule::unique('room_units', 'room_number')->ignore($this->roomUnitId),
            ],
            'status' => 'required|in:available,maintenance,occupied',
        ];
    }

    public function messages(): array
    {
        return [
            'room_number.required' => 'Nomor kamar wajib diisi.',
            'room_number.unique' => 'Nomor kamar sudah terdaftar.',
            'room_number.max' => 'Nomor kamar maksimal 25 karakter.',
            'status.required' => 'Status unit wajib dipilih.',
            'status.in' => 'Status unit tidak valid.',
        ];
    }
}
