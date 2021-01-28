<?php

namespace App\Gateways\PlaceToPay;

use App\Gateways\GatewayInterface;
use App\Gateways\PaymentGatewayFactory;

class PlaceToPayGatewayFactory extends PaymentGatewayFactory
{

    /**
     * @inheritDoc
     */
    public function create(): GatewayInterface
    {
        return new PlaceToPay();
    }
}
