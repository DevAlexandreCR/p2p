<?php

namespace App\Http\Controllers;

use App\Decorators\CartDecorator;
use App\Http\Requests\Carts\DeleteRequest;
use App\Http\Requests\Carts\UpdateRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{

    private $carts;

    public function __construct(CartDecorator $carts)
    {
        $this->authorizeResource(User::class);
        $this->carts = $carts;
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
        $this->carts->store($request, $user);

        return back()->with('success', trans('products.added'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Renderable
     */
    public function show(User $user): Renderable
    {
        return view('home.users.cart', [
            'user' => $this->carts->show($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $this->carts->update($request, $user);

        return redirect(route('cart.show', $user->id))
            ->with('success', trans('resources.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(DeleteRequest $request, User $user): RedirectResponse
    {
        $this->carts->delete($request, $user);

        return back()->with('success', trans('resources.removed'));
    }
}
