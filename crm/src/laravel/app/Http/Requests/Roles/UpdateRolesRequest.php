<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolesRequest extends FormRequest
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
            'name' => [ 'required', 'string', 'max:100', 'unique:roles,name,'.  $this->role ],
            'description' => [ 'nullable', 'string', 'max:500' ],
            'role' => 'required|integer|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|integer|exists:permissions,id',
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return array_merge($this->route()->parameters(), $this->all());
    }
}
