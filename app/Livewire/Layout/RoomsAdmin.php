<?php

namespace App\Livewire\Layout;

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

    public function save(): void
    {
        $validated = $this->validate();
        $imageName = Str::uuid() . '.' . $this->image->getClientOriginalExtension();

        $this->image->storeAs(
            'assets/img/rooms',
            $imageName,
            'public'
        );

        Room::create([
            ...$validated,
            'slug' => $this->uniqueSlug($validated['name']),
            'image' => $imageName,
        ]);

        $this->resetForm();
        $this->dispatch('room-saved', message: 'Kamar berhasil ditambahkan.');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'description', 'bed_type', 'size', 'capacity', 'price', 'image']);
        $this->status = 'available';
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

        return view('livewire.layout.rooms-admin', [
            'rooms' => $rooms,
            'roomStats' => [
                'total' => Room::count(),
                'available' => Room::where('status', 'available')->count(),
                'occupied' => Room::where('status', 'occupied')->count(),
                'maintenance' => Room::where('status', 'maintenance')->count(),
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
            'image' => 'required|file|mimes:png,jpg|max:2048',
        ];
    }

    private function uniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name) ?: Str::random(8);
        $slug = $baseSlug;
        $suffix = 2;


        while (Room::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
