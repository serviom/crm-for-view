<?php

namespace App\Http\Requests\Users;

use App\Models\Client;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteUsersRequest extends FormRequest
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
            'user' => [
                'integer',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $this->isUserHasClients = Client::whereHas('user', function (Builder $query) use ($value) {
                        $query->where('users.id', $value);
                    })->count();

                    if(! empty(request()->user_id) && isset(request()->user_id)) $this->isUserHasClients = false;

                    if ($this->isUserHasClients) $fail(true);
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
                'message' => $this->isUserHasClients ? 'Користувач має клієнтів' : 'Модель не знайдена',
                'status' => 'error'
            ], 422)
        );
    }
}
