<?php


namespace App\Gateways\FakePayment;


use App\Gateways\GatewayInterface;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;

class FakePayment implements GatewayInterface
{

    /**
     * @inheritDoc
     */
    public function create(Order $order): RedirectResponse
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function getInformation(Payment $payment): string
    {
        // TODO: Implement getInformation() method.
    }

    /**
     * @inheritDoc
     */
    public function retry(Payment $payment): RedirectResponse
    {
        // TODO: Implement retry() method.
    }

    /**
     * @inheritDoc
     */
    public function reverse(Payment $payment): RedirectResponse
    {
        // TODO: Implement reverse() method.
    }
}