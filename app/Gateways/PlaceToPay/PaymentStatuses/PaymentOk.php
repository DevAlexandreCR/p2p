<?php


namespace App\Gateways\PlaceToPay\PaymentStatuses;


use App\Gateways\Statuses;
use App\Gateways\UpdatePaymentInterface;
use App\Models\Payment;

class PaymentOk implements UpdatePaymentInterface
{

    /**
     * @inheritDoc
     */
    public function update(Payment $payment, ?object $response): void
    {
        $requestId = $response->requestId;
        $processUrl = $response->processUrl;
        $payment->update([
            'request_id'  => $requestId,
            'process_url' => $processUrl,
            'status'      => Statuses::STATUS_PENDING
        ]);
    }
}