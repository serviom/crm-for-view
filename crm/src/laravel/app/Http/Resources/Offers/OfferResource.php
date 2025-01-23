<?php
namespace App\Http\Resources\Offers;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'order_id' => $this->order_id,
            'link' => $this->link,
            'comment' => $this->comment,
            'archive' => $this->archive,
            'order' => $this->order,
            'show_date' => $this->show_date,
            'created' => $this->created,
            'img' => $this->img,
            'domain' => $this->domain,
        ];
    }
}
