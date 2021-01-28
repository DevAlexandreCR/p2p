<?php

namespace App\View\Components;

use App\Models\Payment;
use Illuminate\View\Component;
use Illuminate\View\View;

class StatusPayment extends Component
{
    public Payment $payment;

    /**
     * Create a new component instance.
     *
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.status-payment');
    }
}
