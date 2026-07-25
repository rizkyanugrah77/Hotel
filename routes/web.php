<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// ROLE ADMIN
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/rooms-admin', [RoomController::class, 'index'])->name('rooms-admin');
});

require __DIR__.'/auth.php';
