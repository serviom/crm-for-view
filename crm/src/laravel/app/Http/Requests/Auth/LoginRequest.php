<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Mockery\Exception;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password'  => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Користувача з таким email не знайдено!!!',
        ];
    }

    protected function failedValidation(Validator $validator) : Exception
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $this->makeErrorsOneRecord($validator),
                'status' => 'error'
            ], 422)
        );
    }

    protected function makeErrorsOneRecord(Validator $validator) : string
    {
        $formattedErrors = [];
        $errors = $validator->errors()->messages();

        foreach ($errors as $field => $messages) {
            $formattedErrors[$field] = implode(' ', $messages);
        }

        return implode('. ', $formattedErrors);
    }
}
