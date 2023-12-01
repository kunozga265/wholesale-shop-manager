<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopCollection;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        return response()->json(new ShopCollection($shops));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"              => 'required',
            "location"          => 'required',
            "account_balance"    => 'required',
        ]);

        $shop = Shop::create([
            "name"              => $request->name,
            "location"          => $request->location,
            "account_balance"   => $request->account_balance,
        ]);

        (new AppController())->seedProducts($shop);

        return response()->json($shop);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            "name"              => 'required',
            "location"          => 'required',
            "account_balance"   => 'required',
        ]);

        $shop = Shop::findOrFail($id);

        $shop->update([
            "name"              => $request->name,
            "location"          => $request->location,
            "account_balance"   => $request->account_balance,
        ]);

        return response()->json($shop);
    }
}
