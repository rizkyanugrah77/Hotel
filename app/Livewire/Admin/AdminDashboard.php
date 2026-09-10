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

        $successfulPayments = Payment::query()
            ->whereIn('transaction_status', PaymentStatus::successful())
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->get(['created_at']);

        if ($this->reportPeriod === 'weekly') {
            $labels = collect(range(0, 6))->map(fn($offset) => $currentStart->copy()->addDays($offset)->translatedFormat('D - d'));

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

        $paidStatuses = PaymentStatus::successful();
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

        $periodPayments = Payment::query()
            ->whereBetween('created_at', [$currentStart, $currentEnd]);

        $statusChartData = [
            'labels' => ['Berhasil', 'Pending', 'Gagal', 'Kedaluwarsa', 'Dibatalkan', 'Dikembalikan'],
            'data' => [
                (clone $periodPayments)->whereIn('transaction_status', $paidStatuses)->count(),
                (clone $periodPayments)->whereIn('transaction_status', PaymentStatus::pending())->count(),
                (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::FAILED->value])->count(),
                (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::EXPIRED->value])->count(),
                (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::CANCEL->value])->count(),
                (clone $periodPayments)->whereIn('transaction_status', [PaymentStatus::REFUND->value])->count(),
            ],
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

        $revenue = Payment::whereIn('transaction_status', $paidStatuses)
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->sum('sub_total_amount');

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
            'chartCapacity',
            'totalRoomUnits',
            'occupiedRoomUnits',
            'occupancyRate',
            'occupiedUnitIds',
            'pendingArrivals'
        ))->layout('layouts.app');
    }
}
