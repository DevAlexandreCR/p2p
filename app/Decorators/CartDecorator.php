<?php

namespace App\Decorators;

use App\Interfaces\CartInterface;
use App\Models\User;
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
        $user->cart->products()->attach($request->input('product_id'), [
            'quantity' => $request->input('quantity')
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function delete(Request $request, User $user): void
    {
        $user->cart->products()->wherePivot('product_id', $request->input('product_id'))->detach();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    public function store(Request $request, User $user)
    {
        var_dump($request->input('quantity'));
        $productId = $request->input('product_id');

        $product = $user->cart->products()->where('product_id', $productId)->first();

        if ($product) {
            $product->pivot->quantity = $product->pivot->quantity + $request->input('quantity');
            return $product->pivot->save();
        }

        return $user->cart->products()->attach($productId, [
            'quantity' => $request->input('quantity')
        ]);
    }
}
