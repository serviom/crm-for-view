<?php
namespace App\Http\Requests\Offers;

use Illuminate\Foundation\Http\FormRequest;

class UploadOrderAudioRequest extends FormRequest
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
            'order_id' => 'exists:orders,id',
            'client_id' => 'exists:clients,id',
            'source' => ['required', 'mimes:mp3'],
        ];
    }

    public function messages()
    {
        return [
            'source.required' => 'Немає аудіо',
            'source.mimes' => 'Немає аудіо',
            'source.max' => 'Занабто великий файл',
            'order_id.exists' => 'Угоди не існує',
            'client_id.exists' => 'Клієнта не існує',
        ];
    }
}
