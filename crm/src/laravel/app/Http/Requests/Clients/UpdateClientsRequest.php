<?php

namespace App\Http\Requests\Clients;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Clients\ClientResource;
use App\Models\ClientPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdateClientsRequest extends FormRequest
{
    protected $phoneNumber_unique_failed = false;
    protected $phoneNumber_unique_client = null;
    protected $phoneNumber_unique_user = null;
    protected $phoneNumber_unique_phoneNumber = null;

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
            'fio' => [ 'required', 'string', 'max:100' ],
            'email' => [ 'nullable', 'string', 'max:100' ],
            'description' => [ 'nullable', 'string', 'max:1000' ],
            'user_id' => [ 'nullable', 'exists:users,id',  ],
            'social' => [ 'required_without:phoneNumbers', 'nullable', 'max:250'],
            'phoneNumbers' => [ 'required_without:social', 'max:100'],
            'phoneNumbers.*.phoneNumber' => [
                'required_without:social', 'string', 'nullable', 'max:100',
                function ($attribute, $value, $fail) {
                    $value= str_replace( ['+38', ' ' , '(', ')', '-'],  '',  $value);
                    $hasUsedClientPhoneNumber = ClientPhone::with('client.user')
                        ->where('phoneNumber', $value)
                        ->where('client_id', '<>', $this->client)
                        ->first();

                    if ($hasUsedClientPhoneNumber) {
                        $this->phoneNumber_unique_failed = true;
                        $this->phoneNumber_unique_phoneNumber = $value;
                        $this->phoneNumber_unique_client = $hasUsedClientPhoneNumber->client;
                        $this->phoneNumber_unique_user = $hasUsedClientPhoneNumber->client->user;
                        $fail('Вказаний телефон вже використовується клієнтом ' . $this->phoneNumber_unique_client->fio);
                    }
                },
                'distinct'
            ],
        ];
    }

    public function messages()
    {
        return [
            'phoneNumbers.*.phoneNumber.distinct' => 'Поле телефон містить значення, яке дублюється',
            'phoneNumbers.*.phoneNumber.unique' => 'Вказаний телефон вже використовується',
            'social.required_without' => 'Поле соцмережі обовʼязкове без телефону',
            'phoneNumbers.*.phoneNumber.required_without' => 'Телефон обовʼязковий без соцмережі',
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

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse([
            'phoneNumber_unique_failed' => $this->phoneNumber_unique_failed,
            'phoneNumber_unique_client' =>  $this->phoneNumber_unique_client ? new ClientResource($this->phoneNumber_unique_client) : null,
            'phoneNumber_unique_user' => $this->phoneNumber_unique_user ? new UserResource($this->phoneNumber_unique_user) : null,
            'phoneNumber_unique_phoneNumber' => $this->phoneNumber_unique_phoneNumber,
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
