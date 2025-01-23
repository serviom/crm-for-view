<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UserExistsWithTrashed;

class RestoreUsersRequest extends FormRequest
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
            'id' => [
                'required',
                'integer',
                new UserExistsWithTrashed,
            ]
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Не вірно вказаний користувач',
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
