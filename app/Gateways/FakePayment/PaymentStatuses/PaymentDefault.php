<?php


namespace App\Gateways\FakePayment\PaymentStatuses;


use App\Gateways\UpdatePaymentInterface;
use App\Models\Payment;

class PaymentDefault implements UpdatePaymentInterface
{

    /**
     * @inheritDoc
     */
    public function update(Payment $payment, ?object $response): void
    {
        $payment->update([
            'status' => $response->status->status
        ]);
    }
}