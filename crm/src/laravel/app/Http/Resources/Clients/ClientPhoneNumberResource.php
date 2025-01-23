<?php

namespace App\Http\Resources\Clients;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientPhoneNumberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'phoneNumber' => BaseController::phone_format($this->phoneNumber),
        ];
    }
}
