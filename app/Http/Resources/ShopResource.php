<?php

namespace App\Http\Resources;

use App\Http\Controllers\AppController;
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

        $sales = $this->summaries()->where("type", (new AppController())->SALE)->orderBy("date","desc")->limit(31)->get();
        $orders = $this->summaries()->where("type", (new AppController())->ORDER)->orderBy("date","desc")->limit(31)->get();

        return [
            'id'                =>  intval($this->id),
            'name'              =>  $this->name,
            'location'          =>  $this->location,
            'account_balance'   =>  floatval($this->account_balance),
            'total'             =>  intval($this->inventory->count()),
            'low_of_stock'      =>  intval($low_of_stock),
            'out_of_stock'      =>  intval($out_of_stock),
            'inventory'         =>  InventoryResource::collection($this->inventory),
            'sales'             =>  SummaryResource::collection($sales),
            'orders'            =>  SummaryResource::collection($orders),

        ];
    }
}
