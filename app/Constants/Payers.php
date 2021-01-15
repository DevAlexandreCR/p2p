<?php


namespace App\Constants;


use MyCLabs\Enum\Enum;

class Payers extends Enum
{
    const DOC_TYPE_CC = 'CC';
    const DOC_TYPE_AS = 'AS';
    const DOC_TYPE_CE = 'CE';
    const DOC_TYPE_PA = 'PA';
    const DOC_TYPE_RC = 'RC';
    const DOC_TYPE_TI = 'TI';
}
