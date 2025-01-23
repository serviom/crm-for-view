<?php

namespace App\Http\Resources\Clients;

use App\Http\Resources\Auth\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AllUsersResource extends JsonResource
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
            'name' => $this->name,
        ];
    }
}
