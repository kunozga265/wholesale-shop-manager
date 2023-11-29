<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => intval($this->id),
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'code'          => intval($this->code),
            'role'          =>  $this->roles()->first()
        ];
    }
}
