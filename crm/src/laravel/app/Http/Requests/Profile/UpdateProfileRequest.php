<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    protected $user = null;
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
        $this->user = Auth::guard()->user()->getAuthIdentifier();
        return [
            'name' => [ 'required', 'string', 'max:100' ],
            'email' => [ 'required', 'string', 'max:100', 'unique:users,email,' .  $this->user ],
            'phoneNumber' => [ 'nullable', 'string', 'max:100', 'unique:users,phoneNumber,'.  $this->user ],
            'password' => [ 'nullable', 'string', 'min:8', 'max:100',  ],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Вказаний email вже використовується',
            'phoneNumber.unique' => 'Вказаний номер вже використовується',
        ];
    }
}
