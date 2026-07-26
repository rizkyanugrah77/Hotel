<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class RoomsAdmin extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $description = '';

    public string $bed_type = '';

    public string $size = '';

    public string $capacity = '';

    public string $price = '';

    public string $status = 'available';

    public ?object $image = null;

    public string $search = '';

    public string $filterStatus = '';

    public ?int $editingRoomId = null;

    public ?int $roomToDelete = null;

    public function save(): void
    {
        $validated = $this->validate();

        $room = $this->editingRoomId ? Room::findOrFail($this->editingRoomId) : null;
        $attributes = collect($validated)->except('image')->all();

        if ($this->image) {
            $imageName = Str::uuid().'.'.$this->image->getClientOriginalExtension();
            $this->image->storeAs('assets/img/rooms', $imageName, 'public');
            $attributes['image'] = $imageName;
        }

        if ($room) {
            if ($room->name !== $attributes['name']) {
                $attributes['slug'] = $this->uniqueSlug($attributes['name'], $room->id);
            }

            $room->update($attributes);
        } else {
            Room::create([
                ...$attributes,
                'slug' => $this->uniqueSlug($attributes['name']),
            ]);
        }

        $this->resetForm();

        $this->dispatch('room-saved', message: $room ? 'Kamar berhasil diperbarui.' : 'Kamar berhasil ditambahkan.');
    }

    public function edit(int $roomId): void
    {
        $room = Room::findOrFail($roomId);

        $this->editingRoomId = $room->id;
        $this->name = $room->name;
        $this->description = $room->description ?? '';
        $this->bed_type = $room->bed_type ?? '';
        $this->size = (string) $room->size;
        $this->capacity = (string) $room->capacity;
        $this->price = (string) $room->price;
        $this->status = $room->status ?? 'available';
        $this->image = null;
        $this->resetValidation();

        $this->dispatch('room-editing');
    }

    public function confirmDelete(int $roomId): void
    {
        $this->roomToDelete = Room::findOrFail($roomId)->id;

        $this->dispatch('room-delete-confirmation');
    }

    public function delete(): void
    {
        abort_unless($this->roomToDelete, 404);

        Room::findOrFail($this->roomToDelete)->delete();
        $this->roomToDelete = null;

        $this->dispatch('room-deleted', message: 'Kamar berhasil dihapus.');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'description', 'bed_type', 'size', 'capacity', 'price', 'image']);
        $this->status = 'available';
        $this->editingRoomId = null;
        $this->resetValidation();
    }

    public function render()
    {
        $rooms = Room::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus, fn ($query) => $query->where('status', $this->filterStatus))
            ->latest()
            ->get();

        return view('livewire.layout.rooms-manager', [
            'rooms' => $rooms,
            'roomStats' => [
                'total' => Room::query()->count(),
                'available' => Room::query()->where('status', 'available')->count(),
                'occupied' => Room::query()->where('status', 'occupied')->count(),
                'maintenance' => Room::query()->where('status', 'maintenance')->count(),
            ],
        ]);
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'bed_type' => ['required', 'string', 'max:100'],
            'size' => ['required', 'integer', 'min:1', 'max:10000'],
            'capacity' => ['required', 'integer', 'min:1', 'max:1000'],
            'price' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'image' => [$this->editingRoomId ? 'nullable' : 'required', 'file', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    private function uniqueSlug(string $name, ?int $ignoreRoomId = null): string
    {
        $baseSlug = Str::slug($name) ?: Str::random(8);
        $slug = $baseSlug;
        $suffix = 2;

        while (Room::query()->where('slug', $slug)->when($ignoreRoomId, fn ($query) => $query->whereKeyNot($ignoreRoomId))->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
