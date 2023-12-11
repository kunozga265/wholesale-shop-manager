<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item'          =>  'required',
            'stock'         =>  'required',
            'buying'        =>  'required',
            'selling'       =>  'required',
            'category_id'   => 'required',
//            'shop_id'       => 'required',
        ]);

        $product = (new ProductController())->store($request);

        $shops = Shop::all();

        foreach ($shops as $shop) {
            Inventory::create([
                'product_id' => $product->id,
                'shop_id' => $shop->id,
                'stock' => $request->stock,
            ]);
        }

        (new NotificationController())->notify("INVENTORY_NEW", $request->item." has been added to the inventory", user_id: Auth::id());

        return response()->json(['message'=>'Product successfully added!'], 201);
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'item'      =>  'required',
            'stock'     =>  'required',
            'buying'    =>  'required',
            'selling'   =>  'required',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'stock' => $request->stock
        ]);

        // update product
        $inventory->product()->update([
            'item'      => $request->item,
            'buying'    => $request->buying,
            'selling'   => $request->selling
        ]);

        (new NotificationController())->notify("INVENTORY_UPDATE", $request->item." has been updated in the inventory", user_id: Auth::id());

        return response()->json(['message'=>'Product successfully update!'], 201);
    }
}
