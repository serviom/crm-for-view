<?php

namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersRequest extends FormRequest
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
            'user' => 'integer|exists:users,id',
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return $this->route()->parameters();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Модель не знайдена',
                'status' => 'error'
            ], 404)
        );
    }
}
