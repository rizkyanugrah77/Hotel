<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Carbon;
use Livewire\Component;

class AdminDashboard extends Component
{
    public string $reportPeriod = 'daily';

    public string $reportDate;

    public string $reportMonth;

    public int $reportYear;

    public function mount(): void
    {
        $this->reportDate = today()->format('Y-m-d');
        $this->reportMonth = today()->format('Y-m');
        $this->reportYear = today()->year;
    }

    public function render()
    {
        $rooms = Room::with(['units', 'bookings.user', 'bookings.room'])->get();

        $totalRevenue = Booking::where('status', 'paid')->sum('total_price');
        $totalBookings = Booking::count();
        $activeBookings = Booking::where('status', 'pending')->count();
        $transactionsQuery = Payment::query()
            ->with('booking.room', 'user');
        // chart booking by month
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

        $roomStats = $rooms->groupBy('name')->map(function ($group) {
            return [
                'total' => $group->count(),
                'occupied' => $group->where('status', '!=', 'cancelled')->count(),
                'available' => $group->where('status', 'cancelled')->count(),
            ];
        });

        return view('admin.dashboard', compact(
            'rooms',
            'totalRevenue',
            'totalBookings',
            'activeBookings',
            'roomStats',
            'paymentMethods',
            'chartData',
            'statusChartData'
        ))->layout('layouts.app');
    }
}
