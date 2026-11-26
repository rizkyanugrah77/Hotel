<?php

namespace App\Livewire\Admin;

use App\Enums\PaymentStatus;
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

        $paidStatuses = PaymentStatus::successful();

        $successfulPayments = Payment::query()
            ->with('booking.room')
            ->whereIn('transaction_status', $paidStatuses)
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->get(['id', 'booking_id', 'sub_total_amount', 'created_at']);

        if ($this->reportPeriod === 'weekly') {
            $labels = collect(range(0, 6))->map(fn($offset) => $currentStart->copy()->addDays($offset)->translatedFormat('D, d M'));
            $groupedPayments = $successfulPayments->groupBy(fn($payment) => $payment->created_at->isoWeekday());
            $bucketKeys = range(1, 7);
            $periodLabel = $currentStart->translatedFormat('d M') . ' - ' . $currentEnd->translatedFormat('d M Y');
        } elseif ($this->reportPeriod === 'monthly') {
            $startOfMonth = Carbon::parse($this->reportMonth . '-01')->startOfMonth();
            $labels = collect(range(1, $startOfMonth->daysInMonth))->map(fn($day) => (string) $day);
            $groupedPayments = $successfulPayments->groupBy(fn($payment) => $payment->created_at->day);
            $bucketKeys = range(1, $startOfMonth->daysInMonth);
            $periodLabel = $startOfMonth->translatedFormat('F Y');
        } else {
            $labels = collect(range(1, 12))->map(fn($month) => Carbon::create($this->reportYear, $month)->translatedFormat('M'));
            $groupedPayments = $successfulPayments->groupBy(fn($payment) => $payment->created_at->month);
            $bucketKeys = range(1, 12);
            $periodLabel = 'Tahun ' . $this->reportYear;
        }

        $revenueData = collect($bucketKeys)->map(
            fn($key) => (int) ($groupedPayments->get($key)?->sum('sub_total_amount') ?? 0)
        )->values();

        $transactionCountData = collect($bucketKeys)->map(
            fn($key) => (int) ($groupedPayments->get($key)?->count() ?? 0)
        )->values();

        $paymentMethods = Payment::query()
            ->selectRaw("COALESCE(NULLIF(payment_method, ''), 'Lainnya') as payment_type, COUNT(*) as total, COALESCE(SUM(sub_total_amount), 0) as revenue")
            ->whereIn('transaction_status', $paidStatuses)
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->groupByRaw("COALESCE(NULLIF(payment_method, ''), 'Lainnya')")
            ->orderByDesc('total')
            ->get();

        $chartData = [
            'labels' => $labels->values(),
            'revenueData' => $revenueData,
            'transactionCountData' => $transactionCountData,
        ];

        $periodPayments = Payment::query()
            ->whereBetween('created_at', [$currentStart, $currentEnd]);

        $statusCounts = [
            (clone $periodPayments)->whereIn('transaction_status', $paidStatuses)->count(),
            (clone $periodPayments)->whereIn('transaction_status', PaymentStatus::pending())->count(),
            (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::FAILED->value])->count(),
            (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::EXPIRED->value])->count(),
            (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::CANCEL->value])->count(),
            (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::REFUND->value])->count(),
        ];

        $totalPeriodTransactions = array_sum($statusCounts);
        $successfulCount = $statusCounts[0];

        $statusChartData = [
            'labels' => ['Berhasil', 'Pending', 'Gagal', 'Kedaluwarsa', 'Dibatalkan', 'Dikembalikan'],
            'data' => $statusCounts,
            'total' => $totalPeriodTransactions,
        ];

        $paymentsByRoom = $successfulPayments->groupBy(fn($payment) => $payment->booking?->room?->name ?? 'Lainnya');
        $roomNames = $rooms->pluck('name')->unique()->values();
        $roomPerformance = [
            'labels' => $roomNames,
            'revenues' => $roomNames->map(fn($name) => (int) ($paymentsByRoom->get($name)?->sum('sub_total_amount') ?? 0))->values(),
            'bookings' => $roomNames->map(fn($name) => (int) ($paymentsByRoom->get($name)?->count() ?? 0))->values(),
        ];

        $occupiedUnitIds = Booking::query()
            ->whereIn('status', ['paid', 'checked_in'])
            ->where('check_in', '<', $currentEnd)
            ->where('check_out', '>', $currentStart)
            ->pluck('room_unit_id')
            ->filter()
            ->unique();
        $occupiedRoomUnits = $occupiedUnitIds->count();
        $occupancyRate = $totalRoomUnits > 0 ? round(($occupiedRoomUnits / $totalRoomUnits) * 100, 1) : 0;

        $roomStats = $rooms->groupBy('name')->map(function ($group) use ($occupiedUnitIds) {
            $occupied = $group->flatMap->units->whereIn('id', $occupiedUnitIds)->count();

            return [
                'total' => $group->flatMap->units->count(),
                'occupied' => $occupied,
                'available' => $group->flatMap->units->count() - $occupied,
            ];
        });

        $revenue = (int) $successfulPayments->sum('sub_total_amount');

        $analyticsSummary = [
            'period_label' => $periodLabel,
            'revenue' => $revenue,
            'successful_count' => $successfulCount,
            'total_transactions' => $totalPeriodTransactions,
            'avg_order_value' => $successfulCount > 0 ? (int) round($revenue / $successfulCount) : 0,
            'success_rate' => $totalPeriodTransactions > 0 ? round(($successfulCount / $totalPeriodTransactions) * 100, 1) : 0,
        ];

        $totalRevenue = Payment::whereIn('transaction_status', $paidStatuses)->sum('sub_total_amount');
        $totalBookings = Booking::where('status', '!=', 'cancelled')->count();
        $activeBookings = Booking::whereIn('status', ['pending', 'checked_in', 'paid'])->count();
        $pendingArrivals = Booking::where('status', 'pending')->whereDate('check_in', Carbon::today())->count();

        return view('admin.dashboard', compact(
            'rooms',
            'recentBookings',
            'revenue',
            'totalRevenue',
            'totalBookings',
            'activeBookings',
            'roomStats',
            'paymentMethods',
            'chartData',
            'statusChartData',
            'roomPerformance',
            'analyticsSummary',
            'chartCapacity',
            'totalRoomUnits',
            'occupiedRoomUnits',
            'occupancyRate',
            'occupiedUnitIds',
            'pendingArrivals'
        ))->layout('layouts.app');
    }
}
