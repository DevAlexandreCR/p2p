<?php

namespace App\Gateways;

use MyCLabs\Enum\Enum;

class Statuses extends Enum
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_APPROVED_PARTIAL = 'APPROVED_PARTIAL';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_PENDING_VALIDATION = 'PENDING_VALIDATION';
    public const STATUS_REFUNDED = 'REFUNDED';
    public const STATUS_OK = 'OK';
}
