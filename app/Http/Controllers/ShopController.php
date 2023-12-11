<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopCollection;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        (new NotificationController())->notify("SHOP_NEW", $request->name." Shop has been added in the system", shop_id: $shop->id, user_id: Auth::id());

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

        (new NotificationController())->notify("SHOP_UPDATE", $request->name." Shop has been updated", shop_id: $shop->id, user_id: Auth::id());

        return response()->json($shop);
    }
}
