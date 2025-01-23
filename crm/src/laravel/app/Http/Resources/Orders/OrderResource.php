<?php
namespace App\Http\Resources\Orders;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'client_id' => $this->client_id,
            'adv_type' => $this->adv_type,
            'category' => $this->category,
            'type' => $this->type,
            'repair' => $this->repair,
            'comment' => $this->comment,
            'stage_id' => $this->stage_id,
            'walls' => $this->walls,
            'price' => $this->price,
            'apartment_number' => $this->apartment_number,
            'house_number' => $this->house_number,
            'rooms' => OrderRoomsResource::collection($this->whenLoaded('rooms')),
            'floors' => OrderFloorsResource::collection($this->whenLoaded('floors')),
            'districts' => OrderDistrictsResource::collection($this->whenLoaded('districts')),
            'street' => $this->street,
            'city_id' => $this->city_id,
            'client' => $this->client,
            'color' => $this->color,
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'closed_at' => $this->closed_at,
            'last_comment_date' => $this->last_comment_date
        ];
    }
}
