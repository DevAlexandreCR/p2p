<?php

namespace App\Http\Requests\Products;

use App\Constants\Permissions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => ['string', 'max:30', 'nullable'],
            'reference' => ['string', 'max:10', 'nullable'],
            'min'       => ['integer', 'min:0'],
            'max'       => ['integer', 'min:0'],
            'admin'     => ['boolean'],
            'orderBy'   => ['string', Rule::in(['name', 'reference', 'price', 'enabled'])],
            'order'     => ['string', Rule::in(['asc', 'desc'])]
        ];
    }
}
