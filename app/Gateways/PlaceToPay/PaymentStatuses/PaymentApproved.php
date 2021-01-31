<?php

namespace App\Gateways\PlaceToPay\PaymentStatuses;

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
        $payer = $response->request->payer;
        $dbPayer = Payer::create(
            [
                'document'      => $payer->document,
                'document_type' => $payer->documentType,
                'email'         => $payer->email,
                'name'          => $payer->name,
                'last_name'     => $payer->surname,
                'phone'         => $payer->mobile,
            ]
        );
        $payment->update([
            'payer_id'   => $dbPayer->id,
            'reference'  => $response->payment[0]->internalReference,
            'method'     => $response->payment[0]->paymentMethod,
            'last_digit' => $response->payment[0]->processorFields[0]->value,
            'status'     => $response->status->status
        ]);
        $payment->order()->update([
            'status' => Orders::STATUS_COMPLETED
        ]);
    }
}
