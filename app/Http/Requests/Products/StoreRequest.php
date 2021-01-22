<?php

namespace App\Http\Requests\Products;

use App\Constants\Permissions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows(Permissions::CREATE_PRODUCTS);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:30', 'min:2'],
            'description' => ['required', 'string', 'min:10', 'max:255'],
            'reference'   => ['required', 'alpha_num', 'min:4', 'max:6', 'unique:products,reference'],
            'stock'       => ['required', 'integer', 'min:1'],
            'price'       => ['required', 'numeric', 'min:0.1'],
            'image'       => ['required', 'image']
        ];
    }
}
