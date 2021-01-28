<?php

namespace App\Http\Controllers;

use App\Decorators\OrderDecorator;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $orders;

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
    public function index(User $user):  Renderable
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
        return view('home.users.orders.show', [
            'order' => $this->orders->show($order)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return Renderable
     */
    public function update(Request $request, Order $order): Renderable
    {
        $message = $this->orders->update($request, $order);

        return view('home.users.orders.show', [
            'order' => $order->refresh()
        ])->with('success', $message);
    }
}
