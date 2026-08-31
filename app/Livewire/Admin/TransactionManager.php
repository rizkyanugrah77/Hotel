<?php

namespace App\Livewire\Admin;

use App\Exports\TransactionsExport;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Monolog\Processor\MemoryPeakUsageProcessor;

class TransactionManager extends Component
{
    use WithPagination;

    public string $search = '';

    public $filterStatus = '';

    public string $reportPeriod = 'daily';

    public string $reportDate;

    public string $reportMonth;
    public $promos;

    public int $reportYear;

    public function mount()
    {
        $this->reportDate = today()->format('Y-m-d');
        $this->reportMonth = today()->format('Y-m');
        $this->reportYear = today()->year;
        $this->promos = Promo::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedReportPeriod()
    {
        $this->resetPage();
    }

    public function updatedReportDate()
    {
        $this->resetPage();
    }

    public function updatedReportMonth()
    {
        $this->resetPage();
    }

    public function updatedReportYear()
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

        $this->applyPeriodFilter($transactionsQuery);

        $transactions = $transactionsQuery->latest()->paginate(10);

        $paymentMethods = Payment::query()
            ->selectRaw("COALESCE(payment_type, payment_method, 'Lainnya') as payment_type, COUNT(*) as total")
            ->groupByRaw("COALESCE(payment_type, payment_method, 'Lainnya')")
            ->orderByDesc('total')
            ->get();

        $paidStatuses = ['success', 'capture', 'settlement', 'deny', 'pending', 'expire'];
        $periodPaymentsQuery = $this->applyPeriodFilter(Payment::query());
        $totalRevenue = (float) (clone $periodPaymentsQuery)->where('transaction_status', 'success')->sum('gross_amount');
        $previousTotalRevenue = (float) $this->applyPreviousPeriodFilter(Payment::query())->where('transaction_status', 'success')->sum('gross_amount');

        return view('livewire.layout.transaction', [
            'transactions' => $transactions,
            'promos' => $this->promos,
            'paymentMethods' => $paymentMethods,
            'transactionStats' => [
                'total' => $totalRevenue,
                'total_change' => $previousTotalRevenue > 0
                    ? (($totalRevenue - $previousTotalRevenue) / $previousTotalRevenue) * 100
                    : null,
                'success' => (clone $periodPaymentsQuery)->where('transaction_status', 'success')->count(),
                'pending' => (clone $periodPaymentsQuery)->where('transaction_status', 'pending')->count(),
                'paid' => Booking::whereIn('status', ['paid', 'completed'])->count(),
                'pending_booking' => Booking::where('status', 'pending')->count(),
                'revenue' => (float) Payment::where('transaction_status', 'success')->sum('sub_total_amount'),
                'total_tax' => (float) Payment::where('transaction_status', 'success')->sum('tax_amount'),
                'average' => (float) (clone $periodPaymentsQuery)->whereIn('transaction_status', $paidStatuses)->avg('gross_amount'),
                'highest' => (float) (clone $periodPaymentsQuery)->whereIn('transaction_status', $paidStatuses)->max('gross_amount'),
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

        $this->applyPeriodFilter($query);

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

    private function applyPeriodFilter(Builder $query): Builder
    {
        if ($this->reportPeriod === 'daily') {
            $query->whereDate('created_at', $this->reportDate);
        } elseif ($this->reportPeriod === 'monthly') {
            $query->whereBetween('created_at', [
                Carbon::parse($this->reportMonth . '-01')->startOfMonth(),
                Carbon::parse($this->reportMonth . '-01')->endOfMonth(),
            ]);
        } elseif ($this->reportPeriod === 'yearly') {
            $query->whereYear('created_at', $this->reportYear);
        }

        return $query;
    }

    private function applyPreviousPeriodFilter(Builder $query): Builder
    {
        if ($this->reportPeriod === 'daily') {
            $query->whereDate('created_at', Carbon::parse($this->reportDate)->subDay());
        } elseif ($this->reportPeriod === 'monthly') {
            $previousMonth = Carbon::parse($this->reportMonth . '-01')->subMonth();
            $query->whereBetween('created_at', [
                $previousMonth->copy()->startOfMonth(),
                $previousMonth->copy()->endOfMonth(),
            ]);
        } elseif ($this->reportPeriod === 'yearly') {
            $query->whereYear('created_at', $this->reportYear - 1);
        }

        return $query;
    }
}
