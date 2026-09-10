<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class GuestManager extends Component
{
    use WithPagination;

    public string $search = '';

    public ?User $selectedGuest = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showGuest(int $guestId): void
    {
        $this->resetErrorBag('receipt');
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isReceptionist(), 403);

        $this->selectedGuest = User::query()
            ->where('role', 'customer')
            ->withCount('bookings')
            ->withSum(['bookings as total_spent' => function ($query) {
                $query->where('status', 'paid');
            }], 'total_price')
            ->with(['bookings' => function ($query) {
                $query->with(['room', 'roomUnit', 'payments' => function ($query) {
                    $query->where('transaction_status', 'SUCCESS');
                }])->latest()->limit(5);
            }])
            ->findOrFail($guestId);

        $this->dispatch('guest-detail');
    }

    public function downloadReceipt(int $bookingId)
    {
        $this->resetErrorBag('receipt');
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isReceptionist(), 403);

        $booking = Booking::query()
            ->where('user_id', $this->selectedGuest?->id)
            ->whereHas('user', fn ($query) => $query->where('role', 'customer'))
            ->findOrFail($bookingId);

        $payment = $booking->payments()
            ->where('transaction_status', 'SUCCESS')
            ->with(['booking.room', 'booking.user'])
            ->latest('id')
            ->first();

        if (! $payment || ! in_array($booking->status, ['paid', 'checked_in', 'checked_out'], true)) {
            $this->addError('receipt', 'Kuitansi belum tersedia. Pembayaran harus berhasil dan status booking harus lunas, check-in, atau check-out.');
            return;
        }

        try {
            $pdf = Pdf::loadView('livewire.welcome.payments.receipt', ['payment' => $payment]);
            $pdf->setPaper([0, 0, 230, 500], 'portrait');
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
            $content = $pdf->output();
        } catch (\Throwable $exception) {
            report($exception);
            $this->addError('receipt', 'Kuitansi gagal dibuat. Silakan coba lagi.');
            return;
        }

        return response()->streamDownload(
            fn () => print($content),
            'receipt-' . $payment->order_id . '.pdf'
        );
    }

    public function render()
    {
        $guests = User::where('role', 'customer')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->withCount('bookings')
            ->withSum(['bookings as total_spent' => function ($q) {
                $q->where('status', 'paid');
            }], 'total_price')
            ->latest()
            ->paginate(10);

        $totalGuests = User::where('role', 'customer')->count();
        $newGuestsThisMonth = User::where('role', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $guestsWithBookings = User::where('role', 'customer')->has('bookings')->count();

        return view('livewire.admin.guest-manager', [
            'guests' => $guests,
            'totalGuests' => $totalGuests,
            'newGuestsThisMonth' => $newGuestsThisMonth,
            'guestsWithBookings' => $guestsWithBookings,
        ]);
    }
}
