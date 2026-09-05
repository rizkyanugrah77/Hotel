<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GalleryManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $image;

    public ?int $room_id = null;

    public string $caption = '';

    public int $is_featured = 0;

    public ?int $editingGalleryId = null;

    public $search = '';

    public $perPage = 5;

    public function save()
    {
        $validated = $this->validate();

        $gallery = $this->editingGalleryId ? Gallery::findOrFail($this->editingGalleryId) : null;
        $attributes = collect($validated)->except('image')->all();
        try {
            if ($this->image) {
                $imageName = Str::uuid() . '.' . $this->image->getClientOriginalExtension();
                $this->image->storeAs('assets/img/gallery', $imageName, 'public');
                $attributes['image'] = $imageName;
            }

            if ($gallery) {
                if ($this->image) {
                    Storage::disk('public')->delete('assets/img/gallery/' . $gallery->image);
                }
                $gallery->update($attributes);
            } else {
                Gallery::create($attributes);
            }
            $this->resetForm();
            $this->dispatch('gallery-saved', message: $gallery ? 'Gallery berhasil diperbarui.' : 'Gallery berhasil ditambahkan.', type: 'success');
        } catch (\Throwable $th) {
            $this->dispatch('gallery-error', message: $th->getMessage(), type: 'error');
        }
    }

    public function edit(int $galleryId): void
    {
        $gallery = Gallery::findOrFail($galleryId);

        $this->editingGalleryId = $gallery->id;
        $this->image = null;
        $this->room_id = $gallery->room_id;
        $this->caption = $gallery->caption;
        $this->is_featured = $gallery->is_featured;
        $this->resetValidation();

        $this->dispatch('gallery-editing');
    }

    public function update(): void
    {
        $this->validate();
        $gallery = Gallery::findOrFail($this->editingGalleryId);
        $this->editingGalleryId = $gallery->id;
        if ($this->image) {
            $imageName = Str::uuid() . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('assets/img/gallery', $imageName, 'public');
            $gallery->image = $imageName;
        }

        $gallery->update([
            'room_id' => $this->room_id,
            'caption' => $this->caption,
            'is_featured' => $this->is_featured,
        ]);

        $this->resetForm();

        $this->dispatch('manage-gallery', message: 'Gallery berhasil diperbarui.', type: 'success');
    }

    public function confirmDelete(int $galleryId): void
    {
        $gallery = Gallery::findOrFail($galleryId);
        $this->editingGalleryId = $gallery->id;
        $this->dispatch('gallery-delete-confirmation');
    }

    public function delete(): void
    {
        $gallery = Gallery::findOrFail($this->editingGalleryId);
        if ($gallery->image) {
            Storage::disk('public')->delete('assets/img/gallery/' . $gallery->image);
        }
        $gallery->delete();
        $this->resetForm();
        $this->dispatch('gallery-deleted', message: 'Gallery berhasil dihapus.', type: 'success');
    }

    public function resetForm()
    {
        $this->reset(['image', 'room_id', 'caption', 'is_featured', 'editingGalleryId']);
        $this->editingGalleryId = null;
        $this->resetValidation();
    }

    public function rules()
    {
        return [
            'image' => [$this->editingGalleryId ? 'nullable' : 'required', 'file', 'mimes:png,jpg,jpeg', 'max:2048'],
            'room_id' => 'required|exists:rooms,id',
            'caption' => 'nullable|max:200|string',
            'is_featured' => 'required|in:0,1',
        ];
    }

    public function render()
    {
        return view('livewire.layout.gallery-manager', [
            'galleries' => Gallery::with('room')->paginate($this->perPage),
            'galleryStats' => [
                'total' => Gallery::query()->count(),
                'featured' => Gallery::query()->where('is_featured', 1)->count(),
                'rooms' => Gallery::query()->where('room_id', '!=', null)->count(),
                'regular' => Gallery::query()->where('is_featured', 0)->count(),
                'ratio' => Gallery::query()->where('is_featured', 1)->count() / Gallery::query()->count() * 100,
            ],
            'topRoom' => Room::query()
                ->withCount('galleries')
                ->orderByDesc('galleries_count')
                ->first(),
            'rooms' => Room::all(),
        ])->layout('layouts.app');
    }
}
