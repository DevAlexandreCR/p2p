<?php


namespace App\Constants;


use App\Gateways\FakePayment\FakeGatewayFactory;
use App\Gateways\PlaceToPay\PlaceToPayGatewayFactory;

class PaymentGateway
{
    public const PLACE_TO_PAY = 'placeToPay';
    public const FAKE_PAYMENT = 'fakePayment';

    public const PAYMENT_GATEWAYS = [
        self::PLACE_TO_PAY => PlaceToPayGatewayFactory::class,
        self::FAKE_PAYMENT => FakeGatewayFactory::class
    ];
}