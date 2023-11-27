<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'item'      =>  $this->item,
            'buying'    =>  $this->buying,
            'selling'    =>  $this->selling,
            'category'  =>  new CategoryResource($this->category),

        ];
    }
}
