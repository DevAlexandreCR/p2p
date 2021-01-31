<?php

namespace App\Gateways\PlaceToPay\PaymentStatuses;

use App\Constants\Orders;
use App\Gateways\Statuses;
use App\Gateways\UpdatePaymentInterface;
use App\Models\Payment;

class PaymentRefunded implements UpdatePaymentInterface
{

    /**
     * @inheritDoc
     */
    public function update(Payment $payment, ?object $response): void
    {
        $payment->update([
            'status' => Statuses::STATUS_REFUNDED
        ]);
        $payment->order()->update([
            'status' => Orders::STATUS_CANCELED
        ]);
    }
}
