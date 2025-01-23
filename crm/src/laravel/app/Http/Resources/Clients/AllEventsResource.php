<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Resources\Json\JsonResource;

class AllEventsResource extends JsonResource
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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'fio' => $this->fio,
            'id' => $this->id,
        ];
    }
}
