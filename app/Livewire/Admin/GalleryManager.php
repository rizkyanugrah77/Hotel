<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use App\Models\Room;
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

    public $perPage = 10;

    public function save()
    {
        $validated = $this->validate();
        $galleries = new Gallery;
        $galleries->room_id = $validated['room_id'];
        $galleries->caption = $validated['caption'];
        $galleries->is_featured = $validated['is_featured'];

        $imageName = 'no-image.jpg';
        if ($this->image) {
            $imageName = Str::uuid().'.'.$this->image->getClientOriginalExtension();
            $this->image->storeAs('assets/img/gallery', $imageName, 'public');
        }
        $galleries->image = $imageName;
        try {
            $galleries->save();
            $this->dispatch('gallery-created', message: 'Gallery berhasil ditambahkan.', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('gallery-error', message: 'Gallery gagal ditambahkan.'.$e->getMessage(), type: 'error');
        }
    }

    public function edit(int $galleryId): void
    {
        $gallery = Gallery::findOrFail($galleryId);

        $this->editingGalleryId = $gallery->id;
        $this->image = $gallery->image;
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
        $gallery->update([
            'image' => $this->image,
            'room_id' => $this->room_id,
            'caption' => $this->caption,
            'is_featured' => $this->is_featured,
        ]);

        $this->resetForm();

        $this->dispatch('gallery-updated', message: 'Gallery berhasil diperbarui.');
    }

    public function resetForm()
    {
        $this->reset(['image', 'room_id', 'caption', 'is_featured']);
        $this->resetValidation();
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpg,png,jpeg|unique:galleries,image,'.$this->editingGalleryId.',id,deleted_at,NULL',
            'room_id' => 'required|exists:rooms,id|unique:galleries,room_id,'.$this->editingGalleryId.',id,deleted_at,NULL',
            'caption' => 'required|max:200|string',
            'is_featured' => 'required|in:0,1',
        ];
    }

    public function render()
    {
        return view('livewire.layout.gallery-manager', [
            'galleries' => Gallery::with('room')->paginate($this->perPage),
            'rooms' => Room::all(),
        ]);
    }
}
