<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function update(Request $request, int $id)
    {
        $request->validate([
            'stock'     =>  'required'
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'stock' => $request->stock
        ]);
        return response()->json(['message'=>'Stock successfully update!'], 201);
    }
}
