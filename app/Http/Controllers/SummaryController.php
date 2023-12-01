<?php

namespace App\Http\Controllers;

use App\Http\Resources\SummaryCollection;
use App\Http\Resources\SummaryResource;
use App\Models\Inventory;
use App\Models\Shop;
use App\Models\Summary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index()
    {
        $summaries = Summary::orderBy("date", "desc")->paginate(20);
        return response()->json(new SummaryCollection($summaries));
    }

    public function store(Request $request)
    {
        $request->validate([
            "amount"        => 'required',
            "date"          => 'required',
            "shop_id"       => 'required',
            "type"          => 'required',
            "products"      => 'required',
        ]);

        $shop = Shop::findOrFail($request->shop_id);

        // ORDER
        if ($request->type) {
            foreach ($request->products as $product){
                $inventory = Inventory::findOrFail($product["inventory_id"]);
                $inventory->update([
                    "stock" => $inventory->stock + $product["quantity"]
                ]);
            }

            //add total to shop
            $shop->update([
                "account_balance"   => $shop->account_balance - $request->amount
            ]);
        }
        //SALE
        else{
            foreach ($request->products as $product){
                $inventory = Inventory::findOrFail($product["inventory_id"]);
                $inventory->update([
                    "stock" => $inventory->stock - $product["quantity"]
                ]);
            }

            //subtract total from shop
            $shop->update([
                "account_balance"   => $shop->account_balance + $request->amount
            ]);
        }

        $summary = Summary::create([
            "amount" => $request->amount,
            "date" => $request->date,
            "shop_id" => $request->shop_id,
            "user_id" => /*Auth::id()*/ 1,
            "type" => $request->type,
            "products" => json_encode($request->products),
        ]);

        return response()->json(new SummaryResource($summary));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            "amount"        => 'required',
            "products"      => 'required',
        ]);

        /*
        * undo changes*
        * 1. Correct Amount
        * 2. Correct Stock
        */

        $summary = Summary::find($id);
        $difference = $summary->amount - $request->amount;

        //ORDER
        if($summary->type){
            // More materials have been ordered,
            // Stock should increase and account balance deducted

            //Deducts when differences is greater than initial amount and adds if it is lesser
            $summary->shop()->update([
                'account_balance' => $summary->shop->account_balance - $difference
            ]);
        }else{
            //Adds when differences is greater than initial amount and subtracts if it is lesser
            $summary->shop()->update([
                'account_balance' => $summary->shop->account_balance + $difference
            ]);
        }

        // Re-store stock to the original value
        foreach (json_decode($summary->products) as $product){
            $inventory = Inventory::findOrFail($product["inventory_id"]);
            $inventory->update([
                "stock" => $product["stock"]
            ]);
        }

        // Recalculate the summary
        // ORDER
        if ($summary->type) {
            foreach ($request->products as $product){
                $inventory = Inventory::findOrFail($product["inventory_id"]);
                $inventory->update([
                    "stock" => $inventory->stock + $product["quantity"]
                ]);
            }

            //add total to shop
            $summary->shop()->update([
                "account_balance"   => $summary->shop()->account_balance - $request->amount
            ]);
        }
        //SALEk
        else{
            foreach ($request->products as $product){
                $inventory = Inventory::findOrFail($product["inventory_id"]);
                $inventory->update([
                    "stock" => $inventory->stock - $product["quantity"]
                ]);
            }

            //subtract total from shop
            $summary->shop()->update([
                "account_balance"   => $summary->shop()->account_balance + $request->amount
            ]);
        }

        $summary->update([
            "amount" => $request->amount,
            "products" => json_encode($request->products),
        ]);

        return response()->json(new SummaryResource($summary));

    }
}
