<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

class Orders extends Enum
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_CANCELED = 'CANCELED';
    public const STATUS_COMPLETED = 'COMPLETED';
}
