<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

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
            'shop_id'       => 'required',
        ]);

        $product = (new ProductController())->store($request);

        $inventory = Inventory::create([
            'product_id'    => $product->id,
            'shop_id'       => $request->shop_id,
            'stock'         => $request->stock,
        ]);

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

        return response()->json(['message'=>'Product successfully update!'], 201);
    }
}
