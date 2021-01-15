<?php


namespace App\Constants;

class Orders
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_CANCELED = 'CANCELED';
    public const STATUS_COMPLETED = 'COMPLETED';

    public static function getAll(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELED,
        ];
    }
}
