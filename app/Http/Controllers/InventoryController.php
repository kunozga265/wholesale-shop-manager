<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
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
