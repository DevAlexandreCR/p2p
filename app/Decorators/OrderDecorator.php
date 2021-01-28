<?php


namespace App\Decorators;


use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
     * @return mixed
     */
    public function store(Request $request)
    {

        Cache::tags('users.orders')->flush();
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        Cache::tags('users.orders')->flush();
    }

}