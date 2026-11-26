<?php

namespace App\Enums;

enum BookingStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case CHECKED_IN = 'checked_in';
    case CHECKED_OUT = 'checked_out';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
    case REFUND_REQUIRED = 'refund_required';

    public static function blocking(): array
    {
        return [self::PAID->value, self::CHECKED_IN->value];
    }

    public static function adminTransitionsFor(string $from): array
    {
        return match ($from) {
            self::PENDING->value => [self::CANCELLED->value => 'Cancelled'],
            self::PAID->value => [self::CHECKED_IN->value => 'Checked In'],
            self::CHECKED_IN->value => [self::CHECKED_OUT->value => 'Checked Out'],
            default => [],
        };
    }

    public function label(): string
    {
        return ucwords(str_replace('_', ' ', $this->value));
    }
}
