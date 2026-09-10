<?php

use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $statuses = [
            'pending' => PaymentStatus::PENDING->value,
            'challenge' => PaymentStatus::CHALLENGE->value,
            'capture' => PaymentStatus::SUCCESS->value,
            'settlement' => PaymentStatus::SUCCESS->value,
            'success' => PaymentStatus::SUCCESS->value,
            'paid' => PaymentStatus::SUCCESS->value,
            'deny' => PaymentStatus::FAILED->value,
            'failed' => PaymentStatus::FAILED->value,
            'expire' => PaymentStatus::EXPIRED->value,
            'expired' => PaymentStatus::EXPIRED->value,
            'cancelled' => PaymentStatus::CANCEL->value,
            'cancel' => PaymentStatus::CANCEL->value,
            'refund' => PaymentStatus::REFUND->value,
        ];

        foreach ($statuses as $legacyStatus => $status) {
            DB::table('payments')
                ->whereRaw('LOWER(transaction_status) = ?', [$legacyStatus])
                ->update(['transaction_status' => $status]);
        }
    }

    public function down(): void
    {
    }
};
