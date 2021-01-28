<?php

namespace App\Http\Requests\Users;

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
        return Gate::allows(Permissions::CREATE_USERS, $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', 'string'],
            'password-confirm' => ['required', 'string', 'same:password']
        ];
    }
}
