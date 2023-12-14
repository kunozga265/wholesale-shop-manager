<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseCollection;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);
        $expenses = $shop->expenses()->orderBy("date", "desc")->limit(20)->get();
        return response()->json(ExpenseResource::collection($expenses));
    }

    public function store(Request $request)
    {
        $request->validate([
            "title"         => 'required',
            "amount"        => 'required',
//            "date"          => 'required',
            "shop_id"       => 'required',
        ]);

        $expense = Expense::create([
            "title"         => $request->title,
            "description"   => $request->description,
            "amount"        => $request->amount,
//            "date"          => $request->date,
            "date"          => Carbon::now()->getTimestamp(),
            "shop_id"       => $request->shop_id,
        ]);

        $old_balance = $expense->shop->account_balance;
        $expense->shop()->update([
           'account_balance' => $old_balance - $request->amount
        ]);

        return response()->json([
            "message" => "Successfully recorded the expense"
        ]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            "title"         => 'required',
            "amount"        => 'required',
//            "date"          => 'required',
//            "shop_id"       => 'required',
        ]);

        $expense = Expense::findOrFail($id);
        $difference = $expense->amount - $request->amount;
        $old_balance = $expense->shop->account_balance;

        $expense->shop()->update([
            'account_balance' => $old_balance + $difference
        ]);

        $expense->update([
            "title"         => $request->title,
            "description"   => $request->description,
            "amount"        => $request->amount,
        ]);

        return response()->json([
            "message" => "Successfully updated the expense"
        ]);
    }
}
