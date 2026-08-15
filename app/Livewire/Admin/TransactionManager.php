<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class TransactionManager extends Component
{
    use WithPagination;

    public string $search = '';

    public $filterStatus = '';

    public string $reportPeriod = 'daily';

    public string $reportDate;

    public string $reportMonth;

    public int $reportYear;

    public function mount()
    {
        $this->reportDate = today()->format('Y-m-d');
        $this->reportMonth = today()->format('Y-m');
        $this->reportYear = today()->year;
    }

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
        $transactionsQuery = Payment::query()
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
            });

        // Terapkan filter tanggal berdasarkan periode
        if ($this->reportPeriod === 'daily') {
            $transactionsQuery->whereDate('created_at', $this->reportDate);
        } elseif ($this->reportPeriod === 'monthly') {
            $transactionsQuery->whereBetween('created_at', [
                now()->parse($this->reportMonth . '-01')->startOfMonth(),
                now()->parse($this->reportMonth . '-01')->endOfMonth(),
            ]);
        } elseif ($this->reportPeriod === 'yearly') {
            $transactionsQuery->whereYear('created_at', $this->reportYear);
        }

        $transactions = $transactionsQuery->latest()->paginate(10);

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

    public function exportExcel()
    {
        // Validasi input tanggal
        if ($this->reportPeriod === 'daily' && !$this->reportDate) {
            $this->dispatch('notify', [
                'message' => 'Tanggal harus diisi',
                'type' => 'error',
            ]);

            return;
        }

        if ($this->reportPeriod === 'monthly' && !$this->reportMonth) {
            $this->dispatch('notify', [
                'message' => 'Bulan harus diisi',
                'type' => 'error',
            ]);

            return;
        }

        // Query yang sama seperti di render
        $query = Payment::query()
            ->with('booking.room', 'user')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('order_id', 'like', "%{$this->search}%")
                        ->orWhereHas('booking', function ($q) {
                            $q->where('booking_code', 'like', "%{$this->search}%")
                                ->orWhereHas('room', function ($q) {
                                    $q->where('name', 'like', "%{$this->search}%");
                                });
                        })
                        ->orWhereHas('user', function ($q) {
                            $q->where('name', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->filterStatus, fn($q) => $q->where('transaction_status', $this->filterStatus));

        // Terapkan filter tanggal
        if ($this->reportPeriod === 'daily') {
            $query->whereDate('created_at', $this->reportDate);
        } elseif ($this->reportPeriod === 'monthly') {
            $query->whereBetween('created_at', [
                now()->parse($this->reportMonth . '-01')->startOfMonth(),
                now()->parse($this->reportMonth . '-01')->endOfMonth(),
            ]);
        } elseif ($this->reportPeriod === 'yearly') {
            $query->whereYear('created_at', $this->reportYear);
        }

        // Ambil semua data tanpa pagination
        $payments = $query->latest()->get();

        // Generate file Excel
        return Excel::download(
            new TransactionsExport(
                $payments,
                $this->reportPeriod,
                $this->reportDate,
                $this->reportMonth,
                $this->reportYear
            ),
            "transaksi_{$this->reportPeriod}_{now()->format('YmdHis')}.xlsx"
        );
    }
}
