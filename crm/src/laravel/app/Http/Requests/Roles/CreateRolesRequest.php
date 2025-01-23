<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class CreateRolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [ 'required', 'string', 'max:100', 'unique:roles,name' ],
            'description' => [ 'nullable', 'string', 'max:500' ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|integer|exists:permissions,id',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Вказана роль вже існує.',
        ];
    }
}
