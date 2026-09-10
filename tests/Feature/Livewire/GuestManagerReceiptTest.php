<?php

use App\Livewire\Admin\GuestManager;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Exceptions;
use Livewire\Livewire;

beforeEach(function () {
    $this->staff = User::factory()->create(['role' => 'admin']);
    $this->guest = User::factory()->create(['role' => 'customer']);
    $room = Room::create([
        'name' => 'Receipt Room', 'slug' => 'receipt-room',
        'capacity' => 2, 'price' => 500000, 'status' => 'available',
    ]);
    $unit = RoomUnit::create([
        'room_id' => $room->id, 'room_number' => '101', 'status' => 'available',
    ]);
    $this->booking = Booking::create([
        'booking_code' => 'RECEIPT-TEST',
        'room_id' => $room->id,
        'room_unit_id' => $unit->id,
        'user_id' => $this->guest->id,
        'check_in' => now()->addDay(),
        'check_out' => now()->addDays(2),
        'total_guests' => 2,
        'total_price' => 500000,
        'status' => 'paid',
    ]);
    $this->payment = $this->booking->payments()->create([
        'user_id' => $this->guest->id,
        'order_id' => 'INV-RECEIPT',
        'sub_total_amount' => 500000,
        'tax_amount' => 0,
        'gross_amount' => 500000,
        'payment_method' => 'bank_transfer',
        'transaction_status' => 'SUCCESS',
    ]);
});

it('downloads a real PDF for eligible bookings as staff', function ($role, $status) {
    $this->staff->update(['role' => $role]);
    $this->booking->update(['status' => $status]);

    $component = Livewire::actingAs($this->staff)->test(GuestManager::class)
        ->call('showGuest', $this->guest->id)
        ->assertDispatched('guest-detail')
        ->assertSee('Download receipt')
        ->assertDontSee('Receipt belum tersedia untuk booking ini.')
        ->call('downloadReceipt', $this->booking->id)
        ->assertHasNoErrors()
        ->assertFileDownloaded('receipt-INV-RECEIPT.pdf')
        ->assertSet('selectedGuest.id', $this->guest->id);

    expect(base64_decode($component->effects['download']['content']))->toStartWith('%PDF-');
})->with(['admin', 'receptionist'])->with(['paid', 'checked_in', 'checked_out']);

it('denies customer calls to staff actions', function ($action) {
    Pdf::shouldReceive('loadView')->never();
    Livewire::actingAs($this->guest)->test(GuestManager::class)
        ->call($action, $action === 'showGuest' ? $this->guest->id : $this->booking->id)
        ->assertForbidden();
})->with(['showGuest', 'downloadReceipt']);

it('checks staff authorization again after opening guest details', function () {
    $component = Livewire::actingAs($this->staff)->test(GuestManager::class)
        ->call('showGuest', $this->guest->id);
    $this->staff->update(['role' => 'customer']);

    $component->call('downloadReceipt', $this->booking->id)->assertForbidden();
});

it('denies receipts outside the selected customer scope', function ($scope) {
    Pdf::shouldReceive('loadView')->never();
    $component = Livewire::actingAs($this->staff)->test(GuestManager::class);
    if ($scope !== 'no selection') {
        $component->call('showGuest', $this->guest->id);
        if ($scope === 'other guest') {
            $this->booking->update(['user_id' => User::factory()->create(['role' => 'customer'])->id]);
        } else {
            $this->guest->update(['role' => 'admin']);
        }
    }

    expect(fn () => $component->call('downloadReceipt', $this->booking->id))
        ->toThrow(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
})->with(['no selection', 'other guest', 'no longer customer']);

it('requires current successful payment and eligible booking status', function ($paymentStatus, $bookingStatus) {
    Pdf::shouldReceive('loadView')->never();
    $component = Livewire::actingAs($this->staff)->test(GuestManager::class)
        ->call('showGuest', $this->guest->id);
    $this->booking->update(['status' => $bookingStatus]);
    if ($paymentStatus === null) {
        $this->payment->delete();
    } else {
        $this->payment->update(['transaction_status' => $paymentStatus]);
    }

    $component->call('downloadReceipt', $this->booking->id)
        ->assertHasErrors('receipt')
        ->assertNoFileDownloaded()
        ->assertSet('selectedGuest.id', $this->guest->id);
    expect($component->instance()->getErrorBag()->first('receipt'))->toContain('Pembayaran harus berhasil');
    $component->call('showGuest', $this->guest->id)->assertHasNoErrors('receipt');
})->with([
    [null, 'paid'], ['PENDING', 'paid'], ['FAILED', 'paid'], ['REFUND', 'paid'],
    ['SUCCESS', 'pending'], ['SUCCESS', 'cancelled'], ['SUCCESS', 'refunded'],
]);

it('loads only successful payments and downloads the latest successful attempt', function () {
    $successful = $this->payment->replicate();
    $successful->order_id = 'INV-SUCCESS-2';
    $successful->save();
    $pending = $this->payment->replicate();
    $pending->order_id = 'INV-PENDING';
    $pending->transaction_status = 'PENDING';
    $pending->save();

    $component = Livewire::actingAs($this->staff)->test(GuestManager::class)
        ->call('showGuest', $this->guest->id);
    $booking = $component->get('selectedGuest')->bookings->first();
    expect($booking->relationLoaded('payments'))->toBeTrue()
        ->and($booking->payments->modelKeys())->toBe([$this->payment->id, $successful->id]);

    $component->call('downloadReceipt', $this->booking->id)
        ->assertHasNoErrors()->assertFileDownloaded('receipt-INV-SUCCESS-2.pdf');
});

it('reports PDF output failures and clears the error on retry', function () {
    Exceptions::fake();
    $exception = new RuntimeException('PDF output failed');
    $pdf = Mockery::mock(\Barryvdh\DomPDF\PDF::class);
    Pdf::shouldReceive('loadView')->twice()
        ->with('livewire.welcome.payments.receipt', Mockery::on(fn ($data) => $data['payment']->is($this->payment)))
        ->andReturn($pdf);
    $pdf->shouldReceive('setPaper')->twice()->with([0, 0, 230, 500], 'portrait')->andReturnSelf();
    $pdf->shouldReceive('setOptions')->twice()->with([
        'dpi' => 150, 'defaultFont' => 'sans-serif',
        'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
    ])->andReturnSelf();
    $pdf->shouldReceive('output')->once()->andThrow($exception);
    $pdf->shouldReceive('output')->once()->andReturn('%PDF-test');

    $component = Livewire::actingAs($this->staff)->test(GuestManager::class)
        ->call('showGuest', $this->guest->id)
        ->call('downloadReceipt', $this->booking->id)
        ->assertHasErrors('receipt')->assertNoFileDownloaded()
        ->assertSet('selectedGuest.id', $this->guest->id);
    Exceptions::assertReported(fn (RuntimeException $reported) => $reported === $exception);
    $component->call('downloadReceipt', $this->booking->id)
        ->assertHasNoErrors('receipt')->assertFileDownloaded('receipt-INV-RECEIPT.pdf', '%PDF-test');
});

it('renders the shared receipt when a historical room is missing', function () {
    $this->payment->load(['booking.room', 'booking.user']);
    $this->payment->booking->setRelation('room', null);

    expect(view('livewire.welcome.payments.receipt', ['payment' => $this->payment])->render())
        ->toContain('Kamar tidak tersedia');
});

it('shows an unavailable receipt button for unpaid booking history', function () {
    $this->payment->update(['transaction_status' => 'PENDING']);
    $this->booking->update(['status' => 'pending']);

    $component = Livewire::actingAs($this->staff)->test(GuestManager::class)
        ->call('showGuest', $this->guest->id)
        ->assertSee('Menunggu pembayaran')
        ->assertSee('Receipt belum tersedia untuk booking ini.');

    $document = new DOMDocument;
    @$document->loadHTML($component->html());
    $buttons = (new DOMXPath($document))->query('//button[@aria-label="Download receipt booking RECEIPT-TEST"]');
    expect($buttons->length)->toBe(1)
        ->and($buttons->item(0)->hasAttribute('disabled'))->toBeTrue();
});

it('shows an empty booking history for a new guest', function () {
    $guest = User::factory()->create(['role' => 'customer']);

    Livewire::actingAs($this->staff)->test(GuestManager::class)
        ->call('showGuest', $guest->id)
        ->assertSee('Belum ada riwayat booking')
        ->assertDontSee('Download receipt');
});
