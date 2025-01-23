<?php

namespace App\Http\Resources\Profile;

use App\Services\Users\UsersService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $role = count($this->getRoleNames()) ? $this->getRoleNames()[0] : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => UsersService::makeUrlPathAvatar((string) $this->avatar),
            'telegram_id' => $this->telegram_id,
            'phoneNumber' => $this->phoneNumber,
            'roleName' => $role,
            'password' => "",
        ];
    }
}
