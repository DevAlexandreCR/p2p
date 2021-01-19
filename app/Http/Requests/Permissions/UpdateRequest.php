<?php

namespace App\Http\Requests\Permissions;

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
        return Gate::allows(Permissions::EDIT_PERMISSIONS, $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'permissions'   => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
            'roles'         => ['array'],
            'roles.*'       => ['integer', 'exists:roles,id']
        ];
    }
}
