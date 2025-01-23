<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUsersRequest extends FormRequest
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
            'name' => [ 'required', 'string', 'max:100' ],
            'email' => [ 'required', 'string', 'max:100' ],
            'phoneNumber' => [ 'nullable', 'string', 'max:100', 'unique:users,phoneNumber' ],
            'password' => [ 'required', 'string', 'min:8', 'max:100',  ],
            'roleName' => [ 'required', 'exists:roles,name',  ],
        ];
    }

    public function messages()
    {
        return [
            'phoneNumber.unique' => 'Вказаний номер вже використовується',
        ];
    }
}
