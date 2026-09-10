<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property \App\Models\Booking $booking
 * @property \App\Models\User $user
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'order_id',
        'promo_id',
        'gross_amount',
        'tax_amount',
        'sub_total_amount',
        'payment_type',
        'transaction_id',
        'snap_token',
        'transaction_status',
        'payment_method',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    protected function transactionStatus(): Attribute
    {
        return Attribute::make(
            set: function (PaymentStatus|string|null $status): ?string {
                if ($status instanceof PaymentStatus || $status === null) {
                    return $status?->value;
                }

                $status = match (strtoupper($status)) {
                    'CAPTURE', 'SETTLEMENT', 'PAID' => PaymentStatus::SUCCESS->value,
                    'DENY' => PaymentStatus::FAILED->value,
                    'EXPIRE' => PaymentStatus::EXPIRED->value,
                    'CANCELLED' => PaymentStatus::CANCEL->value,
                    default => strtoupper($status),
                };

                return PaymentStatus::tryFrom($status)?->value
                    ?? throw new \InvalidArgumentException("Unsupported payment status [{$status}].");
            },
        );
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}
