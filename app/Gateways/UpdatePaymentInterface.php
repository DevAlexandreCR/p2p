<?php


namespace App\Gateways;


use App\Models\Payment;

interface UpdatePaymentInterface
{
    /**
     * @param Payment $payment
     * @param object|null $response
     */
    public function update(Payment $payment, ?object $response): void;
}