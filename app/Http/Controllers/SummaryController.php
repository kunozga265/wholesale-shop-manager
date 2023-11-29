<?php

namespace App\Http\Controllers;

use App\Http\Resources\SummaryCollection;
use App\Http\Resources\SummaryResource;
use App\Models\Inventory;
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
//            "user_id"       => 'required',
            "type"          => 'required',
            "products"      => 'required',
        ]);

        // order
        if ($request->type) {
            foreach ($request->products as $product){
                $inventory = Inventory::findOrFail($product["inventory_id"]);
                $inventory->update([
                    "stock" => $inventory->stock + $product["quantity"]
                ]);
            }
        }else{
            foreach ($request->products as $product){
                $inventory = Inventory::findOrFail($product["inventory_id"]);
                $inventory->update([
                    "stock" => $inventory->stock - $product["quantity"]
                ]);
            }
        }

        $summary = Summary::create([
            "amount" => $request->amount,
            "date" => $request->date,
            "user_id" => /*Auth::id()*/ 1,
            "type" => $request->type,
            "products" => json_encode($request->products),
        ]);

        return response()->json(new SummaryResource($summary));
    }
}
