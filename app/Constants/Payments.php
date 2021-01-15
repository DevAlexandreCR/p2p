<?php


namespace App\Constants;

use MyCLabs\Enum\Enum;

class Payments extends Enum
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_APPROVED_PARTIAL = 'APPROVED_PARTIAL';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_PENDING_VALIDATION = 'PENDING_VALIDATION';
    public const STATUS_REFUNDED = 'REFUNDED';
}
