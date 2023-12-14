<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            "id"            =>  intval($this->id),
            "title"         =>  $this->title,
            "description"   =>  $this->description,
            "amount"        =>  floatval($this->amount),
            "date"          =>  floatval($this->date),
            "shop"          =>  $this->shop,
        ];
    }
}
