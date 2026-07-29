<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'index')->name('index');
Route::get('/', [RoomController::class, 'show'])->name('index');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// ROLE ADMIN
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::view('admin/dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('/admin/rooms-manager', [RoomController::class, 'index'])->name('rooms.manager');
    Route::get('/admin/facilities-manager', [FacilityController::class, 'index'])->name('facilities.manager');
    Route::get('/admin/bookings-manager', [BookingController::class, 'index'])->name('bookings.manager');
    Route::view('/admin/gallery-manager', 'admin.gallery-manager')->name('gallery.manager');
});

require __DIR__.'/auth.php';
