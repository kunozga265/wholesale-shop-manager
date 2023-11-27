<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SummaryResource extends JsonResource
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
            'id'        =>  $this->id,
            'date'      =>  $this->date,
            'amount'    =>  $this->amount,
            'type'      =>  $this->type == 0 ? "SALE" : "ORDER" ,
            'user'      =>  new UserResource($this->user),
            'products'  =>  json_decode($this->products),
        ];
    }
}
