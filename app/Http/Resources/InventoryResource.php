<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'id'        =>  intval($this->id),
            'product'   =>  new ProductResource($this->product),
//            'shop'      =>  $this->shop,
            'stock'     =>  intval($this->stock),
        ];
    }
}
