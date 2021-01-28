<?php


namespace App\Interfaces;


use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model);
}