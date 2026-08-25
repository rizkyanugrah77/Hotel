<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $payments;
    protected $reportPeriod;
    protected $reportDate;
    protected $reportMonth;
    protected $reportYear;

    public function __construct($payments, $reportPeriod, $reportDate, $reportMonth, $reportYear)
    {
        $this->payments = $payments;
        $this->reportPeriod = $reportPeriod;
        $this->reportDate = $reportDate;
        $this->reportMonth = $reportMonth;
        $this->reportYear = $reportYear;
    }

    public function collection()
    {
        return $this->payments;
    }

    public function headings(): array
    {
        return [
            'No',
            'Order ID',
            'Tanggal',
            'Kode Booking',
            'User',
            'Kamar',
            'Pajak',
            'Subtotal',
            'Promo',
            'Total',
            'Metode Pembayaran',
            'Status'
        ];
    }

    public function map($payment): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $payment->order_id,
            $payment->created_at->format('d M Y H:i'),
            $payment->booking?->booking_code ?? '-',
            $payment->user?->name ?? '-',
            $payment->booking?->room?->name ?? '-',
            'Rp ' . number_format($payment->tax_amount, 0, ',', '.'),
            'Rp ' . number_format($payment->sub_total_amount, 0, ',', '.'),
            $payment->promo?->discount_type === 'percentage' ? $payment->promo?->discount_value . '%' : 'Rp ' . number_format($payment->promo?->discount_value, 0, ',', '.') ?? '-',
            'Rp ' . number_format($payment->gross_amount, 0, ',', '.'),
            $payment->payment_type,
            ucfirst($payment->transaction_status)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
