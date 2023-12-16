<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            "id"                =>  intval($this->id),
            "type"              =>  $this->type,
            "message"           =>  $this->message,
//            "product"           =>  $this->product,
//            "shop"              =>  $this->shop,
//            "user"              =>  new UserResource($this->user),
            "date"              =>  intval($this->created_at->getTimestamp()),
        ];
    }
}
