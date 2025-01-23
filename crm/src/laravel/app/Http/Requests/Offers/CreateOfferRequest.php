<?php
namespace App\Http\Requests\Offers;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
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
            'link' => 'required|url|min:10',
            'order_id' => 'exists:orders,id'
        ];
    }

    public function messages()
    {
        return [
            'link.required' => 'Посилання введено некоректно',
            'link.min' => 'Посилання введено некоректно',
            'order_id.exists' => 'Угоди не існує',
        ];
    }
}
