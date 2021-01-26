<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Cart;

class CreateCart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        Cart::create([
            'user_id' => $event->user->id
        ]);
    }
}
