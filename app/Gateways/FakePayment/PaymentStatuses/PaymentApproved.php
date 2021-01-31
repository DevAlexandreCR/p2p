<?php

namespace App\Gateways\FakePayment\PaymentStatuses;

use App\Constants\Orders;
use App\Gateways\UpdatePaymentInterface;
use App\Models\Payer;
use App\Models\Payment;

class PaymentApproved implements UpdatePaymentInterface
{

    /**
     * @inheritDoc
     */
    public function update(Payment $payment, ?object $response): void
    {
        $payment->update([
            'status' => $response->status->status
        ]);
        $payment->order()->update([
            'status' => Orders::STATUS_COMPLETED
        ]);
    }
}
