<?php

namespace App\Jobs;

use App\Decorators\OrderDecorator;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QueryStatusPayment implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Order $order;

    public int $tries = 5;

    public int $maxExceptions = 3;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param OrderDecorator $order
     * @return void
     */
    public function handle(OrderDecorator $order): void
    {
        $order->update($this->order);
    }
}
