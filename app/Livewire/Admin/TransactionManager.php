<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionManager extends Component
{
    use WithPagination;

    public string $search = '';

    public $filterStatus = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = Payment::query()
            ->with('booking.room', 'user')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('order_id', 'like', "%{$this->search}%")
                        ->orWhereHas('booking', function ($query) {
                            $query->where('booking_code', 'like', "%{$this->search}%")
                                ->orWhereHas('room', function ($query) {
                                    $query->where('name', 'like', "%{$this->search}%");
                                });
                        })
                        ->orWhereHas('user', function ($query) {
                            $query->where('name', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('transaction_status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        $paymentMethods = Payment::query()
            ->select('payment_type', DB::raw('count(*) as total'))
            ->whereNotNull('payment_type')
            ->groupBy('payment_type')
            ->orderByDesc('total')
            ->get();

        $paidStatuses = ['success', 'capture', 'settlement', 'paid', 'completed'];

        return view('livewire.layout.transaction', [
            'transactions' => $transactions,
            'paymentMethods' => $paymentMethods,
            'transactionStats' => [
                'total' => Payment::count(),
                'success' => Payment::whereIn('transaction_status', $paidStatuses)->count(),
                'pending' => Payment::whereIn('transaction_status', ['pending', 'challenge'])->count(),
                'paid' => Booking::whereIn('status', ['paid', 'completed'])->count(),
                'pending_booking' => Booking::where('status', 'pending')->count(),
                'revenue' => (float) Payment::whereIn('transaction_status', $paidStatuses)->sum('gross_amount'),
                'average' => (float) Payment::whereIn('transaction_status', $paidStatuses)->avg('gross_amount'),
                'highest' => (float) Payment::whereIn('transaction_status', $paidStatuses)->max('gross_amount'),
            ],
        ])->layout('layouts.app');
    }
}
