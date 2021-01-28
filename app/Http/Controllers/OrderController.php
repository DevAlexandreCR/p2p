<?php

namespace App\Http\Controllers;

use App\Constants\Orders;
use App\Decorators\OrderDecorator;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private OrderDecorator $orders;

    public function __construct(OrderDecorator $orders)
    {
        $this->authorizeResource(Order::class);
        $this->orders = $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return Renderable
     */
    public function index(User $user): Renderable
    {
        return view('home.users.orders.index', [
            'orders' => $this->orders->all($user)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        return $this->orders->store($request, $user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param Order $order
     * @return Renderable
     */
    public function show(User $user, Order $order): Renderable
    {
        if ($order->status === Orders::STATUS_PENDING) {
            $this->orders->update($order);
        }

        return view('home.users.orders.show', [
            'order' => $this->orders->show($order)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(User $user, Order $order): RedirectResponse
    {
        $message = $this->orders->update($order);

        return redirect(route('users.orders.show', [$user->id, $order->id]))
            ->with('success', $message);
    }

    /**
     * @param User $user
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function retry(User $user, Order $order): RedirectResponse
    {
        $this->authorize('update', $order);

        return $this->orders->retry($order);
    }

    /**
     * @param User $user
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function reverse(User $user, Order $order): RedirectResponse
    {
        $this->authorize('update', $order);

        return $this->orders->reverse($order);
    }
}
