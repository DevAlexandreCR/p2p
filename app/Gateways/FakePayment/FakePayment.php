<?php

namespace App\Gateways\FakePayment;

use App\Constants\Orders;
use App\Constants\PaymentGateway;
use App\Gateways\FakePayment\PaymentStatuses\PaymentApproved;
use App\Gateways\FakePayment\PaymentStatuses\PaymentDefault;
use App\Gateways\FakePayment\PaymentStatuses\PaymentOk;
use App\Gateways\FakePayment\PaymentStatuses\PaymentRefunded;
use App\Gateways\GatewayContext;
use App\Gateways\GatewayInterface;
use App\Gateways\Statuses;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;

class FakePayment implements GatewayInterface
{

    private string $gateway = PaymentGateway::FAKE_PAYMENT;

    /**
     * @var array|string[]
     */
    protected array $statuses = [
        Statuses::STATUS_APPROVED => PaymentApproved::class,
        Statuses::STATUS_REFUNDED => PaymentRefunded::class,
        Statuses::STATUS_OK       => PaymentOk::class,
        Statuses::STATUS_REJECTED => PaymentDefault::class,
        Statuses::STATUS_FAILED   => PaymentDefault::class
    ];

    /**
     * @inheritDoc
     */
    public function create(Order $order): RedirectResponse
    {
        $response = [
            'status' => [
                'status' => Statuses::STATUS_OK
            ]
        ];

        $this->updatePayment(json_decode(json_encode($response)), $order->payments->first());

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

    /**
     * @inheritDoc
     */
    public function updatePayment($response, Payment $payment): void
    {
        $updateStatus = new $this->statuses[$response->status->status]();

        (new GatewayContext($updateStatus))->updatePayment($payment, $response);
    }
}
