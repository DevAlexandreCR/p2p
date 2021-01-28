<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

class Payers extends Enum
{
    public const DOC_TYPE_CC = 'CC';
    public const DOC_TYPE_AS = 'AS';
    public const DOC_TYPE_CE = 'CE';
    public const DOC_TYPE_PA = 'PA';
    public const DOC_TYPE_RC = 'RC';
    public const DOC_TYPE_TI = 'TI';
}
