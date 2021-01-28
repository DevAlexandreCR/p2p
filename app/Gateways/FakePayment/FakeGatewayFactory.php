<?php


namespace App\Gateways\FakePayment;


use App\Gateways\GatewayInterface;
use App\Gateways\PaymentGatewayFactory;

class FakeGatewayFactory extends PaymentGatewayFactory
{

    /**
     * @inheritDoc
     */
    public function create(): GatewayInterface
    {
        return new FakePayment();
    }
}