<?php

namespace App\Http\Resources\Clients;

use App\Http\Resources\Auth\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'fio' => $this->fio,
            'email' => $this->email,
            'description' => $this->description,
            'income_source_id' => $this->income_source_id,
            'income_source' => $this->income_source,
            'is_agency' => $this->is_agency,
            'agency' => $this->agency,
            'user_id' => $this->user_id,
            'social' => $this->social,
            'user' => new UserResource($this->user),
            'phoneNumbers' => ClientPhoneNumberResource::collection($this->phoneNumbers),
            'order' => $this->order,
            'events' => $this->events,
            'events_count' => $this->events_count,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'create_date' => Carbon::parse($this->create_date)->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at
        ];
    }
}
