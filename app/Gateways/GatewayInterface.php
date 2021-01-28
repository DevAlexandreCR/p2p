<?php


namespace App\Gateways;


use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;

interface GatewayInterface
{
    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function create(Order $order): RedirectResponse;

    /**
     * @param Payment $payment
     * @return string
     */
    public function getInformation(Payment $payment): string;

    /**
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function retry(Payment $payment): RedirectResponse;

    /**
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function reverse(Payment $payment): RedirectResponse;
}