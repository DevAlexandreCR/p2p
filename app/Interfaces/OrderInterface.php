<?php


namespace App\Interfaces;


use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

interface OrderInterface
{
    /**
     * @param User $user
     * @return mixed
     */
    public function all(User $user);

    /**
     * @param Order $order
     * @return mixed
     */
    public function show(Order $order);

    /**
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    public function store(Request $request, User $user);

    /**
     * @param Order $order
     * @return mixed
     */
    public function update(Order $order);

    /**
     * @param Order $order
     * @return mixed
     */
    public function retry(Order $order);

    /**
     * @param Order $order
     * @return mixed
     */
    public function reverse(Order $order);
}