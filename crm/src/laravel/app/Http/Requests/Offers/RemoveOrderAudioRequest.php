<?php
namespace App\Http\Requests\Offers;

use App\Models\OrderAudio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemoveOrderAudioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $orderAudioId = $this->route('id');
        $orderAudio = OrderAudio::find($orderAudioId);
        return $orderAudio && $orderAudio->user_id === Auth::id() || Auth::user()->hasRole('SuperAdmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'exists:order_audious,id',
        ];
    }

    public function messages()
    {
        return [
            'id.exists' => 'Запису не існує',
        ];
    }
}
