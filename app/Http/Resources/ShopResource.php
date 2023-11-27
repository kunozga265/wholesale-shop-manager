<?php

namespace App\Http\Resources;

use App\Models\Inventory;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $low_of_stock = Inventory::where("shop_id",$this->id)->where("stock","<",11)->where("stock",">",0)->count();
        $out_of_stock = Inventory::where("shop_id",$this->id)->where("stock","=",0)->count();

        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'location'      =>  $this->location,
            'total'         =>  $this->inventory->count(),
            'low_of_stock'  =>  $low_of_stock,
            'out_of_stock'  =>  $out_of_stock,
            'inventory'     =>  InventoryResource::collection($this->inventory),

        ];
    }
}
