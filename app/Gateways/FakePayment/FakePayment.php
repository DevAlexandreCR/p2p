<?php

namespace App\Gateways\FakePayment;

use App\Constants\Orders;
use App\Constants\PaymentGateway;
use App\Gateways\GatewayInterface;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;

class FakePayment implements GatewayInterface
{

    private string $gateway = PaymentGateway::FAKE_PAYMENT;

    /**
     * @inheritDoc
     */
    public function create(Order $order): RedirectResponse
    {
        return redirect(route('users.orders.show', [auth()->id(), $order->id]))
            ->with('message', trans('payment.messages.gateway_not_configured'));
    }

    /**
     * @inheritDoc
     */
    public function getInformation(Payment $payment): string
    {
        return Orders::STATUS_COMPLETED;
    }

    /**
     * @inheritDoc
     */
    public function retry(Payment $payment): RedirectResponse
    {
        return redirect(route('users.orders.show', [auth()->id(), $payment->order->id]))
        ->with('message', trans('payment.messages.gateway_not_configured'));
    }

    /**
     * @inheritDoc
     */
    public function reverse(Payment $payment): RedirectResponse
    {
        return back();
    }
}
