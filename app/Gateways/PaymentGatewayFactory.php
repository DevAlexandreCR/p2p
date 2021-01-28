<?php


namespace App\Gateways;


abstract  class PaymentGatewayFactory
{
    /**
     * create new instance of payment gateway
     *
     * @return GatewayInterface
     */
    abstract public function create(): GatewayInterface;
}