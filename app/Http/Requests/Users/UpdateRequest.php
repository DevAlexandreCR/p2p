<?php

namespace App\Http\Requests\Users;

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
        return Gate::allows(Permissions::EDIT_USERS, $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'    => ['string'],
            'email'   => ['email', 'unique:users,email'],
            'enabled' => ['boolean'],
        ];
    }
}
