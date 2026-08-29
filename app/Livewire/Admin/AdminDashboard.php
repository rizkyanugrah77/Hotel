<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomUnit;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    public string $reportPeriod = 'weekly';

    public string $reportDate;

    public string $reportMonth;

    public int $reportYear;

    public int $chartVersion = 0;

    public function mount(): void
    {
        $this->reportDate = today()->format('Y-m-d');
        $this->reportMonth = today()->format('Y-m');
        $this->reportYear = today()->year;
    }

    public function refreshCharts(): void
    {
        $this->chartVersion++;
    }

    public function render()
    {
        $rooms = Room::with('units')->get();
        $recentBookings = Booking::query()
            ->with(['user', 'room', 'roomUnit'])
            ->latest()
            ->paginate(5);

        $totalRevenue = Booking::where('status', 'paid')->sum('total_price');
        $totalBookings = Booking::count();
        $activeBookings = Booking::where('status', 'pending')->count();
        $totalRoomUnits = RoomUnit::count();
        $chartCapacity = max($totalRoomUnits, 1);

        if ($this->reportPeriod === 'weekly') {
            $currentStart = Carbon::parse($this->reportDate)->startOfWeek(Carbon::MONDAY);
            $currentEnd = $currentStart->copy()->endOfWeek(Carbon::SUNDAY);
        } elseif ($this->reportPeriod === 'monthly') {
            $currentStart = Carbon::parse($this->reportMonth . '-01')->startOfMonth();
            $currentEnd = $currentStart->copy()->endOfMonth();
        } else {
            $currentStart = Carbon::create($this->reportYear)->startOfYear();
            $currentEnd = $currentStart->copy()->endOfYear();
        }

        $successfulPayments = Payment::query()
            ->whereRaw('LOWER(transaction_status) = ?', ['success'])
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->get(['created_at']);

        if ($this->reportPeriod === 'weekly') {
            $labels = collect(range(0, 6))->map(fn($offset) => $currentStart->copy()->addDays($offset)->translatedFormat('D'));
            $successfulPaymentsByPeriod = $successfulPayments->countBy(fn($payment) => $payment->created_at->isoWeekday());
            $successData = collect(range(1, 7))->map(fn($day) => min($successfulPaymentsByPeriod->get($day, 0), $chartCapacity));
        } elseif ($this->reportPeriod === 'monthly') {
            $startOfMonth = Carbon::parse($this->reportMonth . '-01')->startOfMonth();
            $labels = collect(range(1, $startOfMonth->daysInMonth))->map(fn($day) => (string) $day);
            $successfulPaymentsByPeriod = $successfulPayments->countBy(fn($payment) => $payment->created_at->day);
            $successData = collect(range(1, $startOfMonth->daysInMonth))->map(fn($day) => min($successfulPaymentsByPeriod->get($day, 0), $chartCapacity));
        } else {
            $labels = collect(range(1, 12))->map(fn($month) => Carbon::create($this->reportYear, $month)->translatedFormat('M'));
            $successfulPaymentsByPeriod = $successfulPayments->countBy(fn($payment) => $payment->created_at->month);
            $successData = collect(range(1, 12))->map(fn($month) => min($successfulPaymentsByPeriod->get($month, 0), $chartCapacity));
        }

        $paidStatuses = ['success', 'capture', 'settlement', 'paid',];
        $paymentMethods = Payment::query()
            ->selectRaw("COALESCE(payment_method, 'Lainnya') as payment_type, COUNT(*) as total")
            ->whereIn('transaction_status', $paidStatuses)
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->groupByRaw("COALESCE(payment_method, 'Lainnya')")
            ->orderByDesc('total')
            ->get();


        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Grafik Penjualan',
                    'data' => $successData,
                    'backgroundColor' => '#059669',
                    'borderRadius' => 6,
                    'borderWidth' => 1,
                    'borderColor' => '#ffffff',
                ],

            ],
        ];

        $statusChartData = [
            'labels' => ['Berhasil', 'Pending', 'Expired', 'Dibatalkan'],
            'data' => [
                Payment::whereIn('transaction_status', $paidStatuses)->count(),
                Payment::whereIn('transaction_status', ['pending', 'challenge'])->count(),
                Payment::whereIn('transaction_status', ['deny', 'expired'])->count(),
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
            'recentBookings',
            'totalRevenue',
            'totalBookings',
            'activeBookings',
            'roomStats',
            'paymentMethods',
            'chartData',
            'statusChartData',
            'chartCapacity',
            'totalRoomUnits'
        ))->layout('layouts.app');
    }
}
