<?php

use App\Livewire\Layout\RoomsAdmin;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('stores a room from the Livewire form', function () {
    Livewire::test(RoomsAdmin::class)
        ->set('name', 'Deluxe Lake View')
        ->set('description', 'Kamar premium dengan pemandangan danau.')
        ->set('bed_type', 'King')
        ->set('size', '45')
        ->set('capacity', '2')
        ->set('price', '1330000')
        ->set('status', 'available')
        ->set('image', 'https://example.com/deluxe-lake-view.jpg')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('room-saved');

    expect(Room::query()->where('slug', 'deluxe-lake-view')->first())
        ->not->toBeNull()
        ->name->toBe('Deluxe Lake View')
        ->price->toBe(1330000);
});
