<?php

namespace App\Http\Requests\Roles;

use App\Models\Client;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteRolesRequest extends FormRequest
{
    protected $isUserHasClients = false;

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
            'role' => [
                'integer','exists:roles,id',
                function ($attribute, $value, $fail) {
                    $this->isUserHasClients = User::whereHas('roles', function (Builder $query) use ($value) {
                        $query->where('roles.id', $value);
                    })->count();
                    if ($this->isUserHasClients) {
                        $fail(true);
                    }
                },
            ],
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
                'message' => $this->isUserHasClients ? "Дана роль використовується" : 'Модель не знайдена',
                'status' => 'error'
            ], 422)
        );
    }
}
