<?php

namespace App\Actions;

use App\Gateways\Statuses;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

class CreateOrderAction
{
    /**
     * @param User $user
     * @param string $gateway
     * @return Order
     */
    public static function execute(User $user, string $gateway): Order
    {
        $order = Order::create([
            'user_id' => $user->id,
            'amount'  => $user->cart->totalCart
        ]);

        optional($user->cart->products())->each(function ($product) use ($order) {
            $order->products()->attach($product->id, [
                'quantity' => $product->pivot->quantity
            ]);
        });

        $pay = Payment::updateOrCreate([
            'order_id' => $order->id
        ], [
            'status' => Statuses::STATUS_PENDING,
            'gateway'  => $gateway,
            'amount'   => $order->amount
        ]);

        $user->cart->products()->detach();

        return $order;
    }
}
