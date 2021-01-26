<?php


namespace App\Decorators;


use App\Interfaces\CartInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CartDecorator implements CartInterface
{

    /**
     * @param User $user
     * @return User
     */
    public function show(User $user): User
    {
        return $user->load('cart');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user): void
    {
        $user->cart->products()->attach($request->get('product_id'), [
            'quantity' => $request->get('quantity')
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function delete(Request $request, User $user): void
    {
        $user->cart->products()->wherePivot('product_id', $request->get('product_id'))->detach();
    }

    /**
     * @param Request $request
     * @param User $user
     */
    public function store(Request $request, User $user): void
    {
        $user->cart->products()->attach($request->get('product_id'), [
            'quantity' => $request->get('quantity')
        ]);
    }
}