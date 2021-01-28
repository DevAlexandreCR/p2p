<?php


namespace App\Decorators;


use App\Constants\PaymentGateway;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderDecorator implements OrderInterface
{

    /**
     * @param User $user
     * @return mixed
     */
    public function all(User $user)
    {
        return Cache::tags('users.orders')->rememberForever($user->name . '-all', function () use($user){
            return $user->orders()->with('payments');
        });
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function show(Order $order)
    {
        return Cache::tags('users.orders')->rememberForever($order->reference, function () use($order){
            return $order->with('payments');
        });
    }

    /**
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    public function store(Request $request, User $user)
    {
        Cache::tags('users.orders')->flush();

        $order = Order::create([
            'user_id' => $user->id,
            'amount'  => $user->cart->totalCart
        ]);

        $user->cart->products()->each(function ($product) use ($order) {
           $order->products()->attach($product->id, [
               'quantity' => $product->pivot->quantity
           ]);
        });

        $paymentGateway = PaymentGateway::PAYMENT_GATEWAYS[$request->input('gateway_name')];

        $payment = (new $paymentGateway)->create();

        return $payment->create($order);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function update(Order $order)
    {
        Cache::tags('users.orders')->flush();

        $paymentGateway = PaymentGateway::PAYMENT_GATEWAYS[$order->payments()->first()->gateway];

        $payment = (new $paymentGateway)->create();

        return $payment->getInformation($order->payments()->first());
    }

    /**
     * @inheritDoc
     */
    public function retry(Order $order)
    {
        Cache::tags('users.orders')->flush();

        $paymentGateway = PaymentGateway::PAYMENT_GATEWAYS[$order->payments()->first()->gateway];

        $payment = (new $paymentGateway)->create();

        return $payment->retry($order->payments()->first());
    }

    /**
     * @inheritDoc
     */
    public function reverse(Order $order)
    {
        Cache::tags('users.orders')->flush();

        $paymentGateway = PaymentGateway::PAYMENT_GATEWAYS[$order->payments()->first()->gateway];

        $payment = (new $paymentGateway)->create();

        return $payment->reverse($order->payments()->first());
    }
}