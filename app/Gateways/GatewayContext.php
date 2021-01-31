<?php


namespace App\Gateways;


use App\Models\Payment;

class GatewayContext
{
    private UpdatePaymentInterface $payment;

    public function __construct(UpdatePaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    public function updatePayment(Payment $payment, ?object $response): void
    {
        $this->payment->update($payment, $response);
    }
}