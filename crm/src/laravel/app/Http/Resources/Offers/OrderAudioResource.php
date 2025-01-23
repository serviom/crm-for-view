<?php
namespace App\Http\Resources\Offers;

use App\Services\Offers\OrderAudioService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderAudioResource extends JsonResource
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
            'user_id' => $this->user_id,
            'hear_date' => $this->hear_date,
            'created' => $this->created_at,
            'filename' => $this->filename,
            'source' => OrderAudioService::makeUrlPathAudio($this->filename),
            'archive' => $this->archive,
        ];
    }
}
