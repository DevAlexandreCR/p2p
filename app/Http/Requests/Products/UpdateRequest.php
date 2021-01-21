<?php

namespace App\Http\Requests\Products;

use App\Constants\Permissions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows(Permissions::EDIT_PRODUCTS);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => ['string', 'max:30', 'min:2'],
            'description' => ['string', 'min:10', 'max:255'],
            'reference'   => ['alpha_num', 'min:4', 'max:6', 'unique:products,reference'],
            'stock'       => ['integer', 'min:1'],
            'price'       => ['numeric', 'min:0.1'],
        ];
    }
}
