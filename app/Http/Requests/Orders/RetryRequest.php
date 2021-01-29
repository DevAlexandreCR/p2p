<?php

namespace App\Http\Requests\Orders;

use App\Constants\PaymentGateway;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class RetryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'gateway_name' => ['required', Rule::in([PaymentGateway::FAKE_PAYMENT, PaymentGateway::PLACE_TO_PAY])]
        ];
    }
}
