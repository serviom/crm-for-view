<?php

namespace App\Http\Resources\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

        $permissions = count($this->getAllPermissions()) ? ($this->getAllPermissions()->pluck('name'))->toArray() : [];
        array_unshift ($permissions, count($this->getRoleNames()) ? $this->getRoleNames()[0] : null);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'telegram_id' => $this->telegram_id,
            'clients_count'=> $this->clients_count,
            'events_count' => $this->events_count,
            'phoneNumber' => BaseController::phone_format($this->phoneNumber),
            'roleName' => $role,
            'permissions' => $permissions,
            'seniorAgent' => $this->seniorAgent->senior_agent_id ?? null,
            'subAgents' => $this->subAgents->pluck('user_id') ?? null,
            'archive' => (boolean) $this->deleted_at,
        ];
    }
}
