<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
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

        $chartQuery = clone $transactionsQuery;

        if ($this->reportPeriod === 'daily') {
            $currentStart = Carbon::parse($this->reportDate)->startOfDay();
            $currentEnd = $currentStart->copy()->endOfDay();
            $previousStart = $currentStart->copy()->subDay();
            $previousEnd = $currentEnd->copy()->subDay();
        } elseif ($this->reportPeriod === 'monthly') {
            $currentStart = Carbon::parse($this->reportMonth . '-01')->startOfMonth();
            $currentEnd = $currentStart->copy()->endOfMonth();
            $previousStart = $currentStart->copy()->subMonthNoOverflow();
            $previousEnd = $previousStart->copy()->endOfMonth();
        } else {
            $currentStart = Carbon::create($this->reportYear)->startOfYear();
            $currentEnd = $currentStart->copy()->endOfYear();
            $previousStart = $currentStart->copy()->subYear();
            $previousEnd = $previousStart->copy()->endOfYear();
        }

        $transactionsQuery->whereBetween('created_at', [$currentStart, $currentEnd]);

        $currentChartPayments = (clone $chartQuery)
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->get(['created_at']);
        $previousChartPayments = (clone $chartQuery)
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->get(['created_at']);

        if ($this->reportPeriod === 'daily') {
            $labels = collect(range(0, 23))->map(fn($hour) => sprintf('%02d:00', $hour));
            $currentCounts = $currentChartPayments->countBy(fn($payment) => $payment->created_at->format('H'));
            $previousCounts = $previousChartPayments->countBy(fn($payment) => $payment->created_at->format('H'));
            $currentData = collect(range(0, 23))->map(fn($hour) => $currentCounts->get(sprintf('%02d', $hour), 0));
            $previousData = collect(range(0, 23))->map(fn($hour) => $previousCounts->get(sprintf('%02d', $hour), 0));
        } elseif ($this->reportPeriod === 'monthly') {
            $startOfMonth = Carbon::parse($this->reportMonth . '-01')->startOfMonth();
            $labels = collect(range(1, $startOfMonth->daysInMonth))->map(fn($day) => (string) $day);
            $currentCounts = $currentChartPayments->countBy(fn($payment) => $payment->created_at->day);
            $previousCounts = $previousChartPayments->countBy(fn($payment) => $payment->created_at->day);
            $currentData = collect(range(1, $startOfMonth->daysInMonth))->map(fn($day) => $currentCounts->get($day, 0));
            $previousData = collect(range(1, $startOfMonth->daysInMonth))->map(fn($day) => $previousCounts->get($day, 0));
        } else {
            $labels = collect(range(1, 12))->map(fn($month) => Carbon::create($this->reportYear, $month)->translatedFormat('M'));
            $currentCounts = $currentChartPayments->countBy(fn($payment) => $payment->created_at->month);
            $previousCounts = $previousChartPayments->countBy(fn($payment) => $payment->created_at->month);
            $currentData = collect(range(1, 12))->map(fn($month) => $currentCounts->get($month, 0));
            $previousData = collect(range(1, 12))->map(fn($month) => $previousCounts->get($month, 0));
        }

        $transactions = $transactionsQuery->latest()->paginate(10);

        $paymentMethods = Payment::query()
            ->selectRaw("COALESCE(payment_type, payment_method, 'Lainnya') as payment_type, COUNT(*) as total")
            ->groupByRaw("COALESCE(payment_type, payment_method, 'Lainnya')")
            ->orderByDesc('total')
            ->get();

        $paidStatuses = ['success', 'capture', 'settlement', 'paid', 'completed'];

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Periode sebelumnya',
                    'data' => $previousData,
                    'borderColor' => '#2563eb',
                    'backgroundColor' => 'rgba(37, 99, 235, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
                [
                    'label' => 'Periode dipilih',
                    'data' => $currentData,
                    'borderColor' => '#059669',
                    'backgroundColor' => 'rgba(5, 150, 105, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                ],

            ],
        ];

        $statusChartData = [
            'labels' => ['Berhasil', 'Pending', 'Gagal', 'Dibatalkan'],
            'data' => [
                Payment::whereIn('transaction_status', $paidStatuses)->count(),
                Payment::whereIn('transaction_status', ['pending', 'challenge'])->count(),
                Payment::whereIn('transaction_status', ['deny', 'failure'])->count(),
                Payment::whereIn('transaction_status', ['cancelled', 'cancel'])->count(),
            ],
        ];

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
            'chartData' => $chartData,
            'statusChartData' => $statusChartData,

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
