<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'PENDING';
    case CHALLENGE = 'CHALLENGE';
    case SUCCESS = 'SUCCESS';
    case FAILED = 'FAILED';
    case EXPIRED = 'EXPIRED';
    case CANCEL = 'CANCEL';
    case REFUND = 'REFUND';

    public static function successful(): array
    {
        return [self::SUCCESS->value];
    }

    public static function pending(): array
    {
        return [self::PENDING->value, self::CHALLENGE->value];
    }

    public static function failed(): array
    {
        return [self::FAILED->value, self::EXPIRED->value, self::CANCEL->value, self::REFUND->value];
    }
}
