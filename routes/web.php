<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\RoomController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\PromoManager;
use App\Livewire\Admin\RoomUnitAdmin;
use App\Livewire\Admin\TransactionManager;
use App\Livewire\welcome\Index;
use App\Livewire\welcome\PaymentController;
use App\Livewire\welcome\PaymentStatus;
use App\Livewire\Welcome\RoomDetail;
use App\Livewire\Welcome\UserDashboard;
use Illuminate\Support\Facades\Route;





// Route::view('/', 'index')->name('index');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('/', Index::class)->name('index');
Route::get('/room/{slug}', RoomDetail::class)->name('room-detail-preview');
Route::view('/view/rooms', 'livewire.welcome.view-rooms')->name('view-rooms');
Route::post('/midtrans/callback', [MidtransController::class, 'callback'])->name('midtrans.callback');


// ROLE ADMIN
Route::middleware(['auth', 'isAdmin', 'verified'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/admin/rooms-manager', [RoomController::class, 'index'])->name('rooms.manager');
    Route::get('/admin/facilities-manager', [FacilityController::class, 'index'])->name('facilities.manager');
    Route::get('/admin/bookings-manager', [BookingController::class, 'index'])->name('bookings.manager');
    Route::view('/admin/gallery-manager', 'admin.gallery-manager')->name('gallery.manager');
    Route::get('/admin/transaction-manager', TransactionManager::class)->name('transaction.manager');
    Route::view('/admin/guest-manager', 'admin.guest')->name('guest.manager');
    Route::get('/admin/room-units-manager/{roomSlug}', RoomUnitAdmin::class)->name('room-units-manager');
    Route::get('/admin/promo-manager', PromoManager::class)->name('promo-manager');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my-dashboard', UserDashboard::class)->name('user.dashboard');
    Route::get('/payment/{bookingCode}', PaymentController::class)->name('payment');
    Route::get('/payment-success/{orderId}', PaymentStatus::class)->name('payment-success');
    Route::view('/payment-check', 'livewire.welcome.payments.payment-redirect')->name('payment-check');
    Route::view('profile', 'profile')->name('profile');
});
require __DIR__ . '/auth.php';
