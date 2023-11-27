<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopCollection;
use App\Http\Resources\SummaryCollection;
use App\Http\Resources\SummaryResource;
use App\Models\Shop;
use App\Models\Summary;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public int $SALE = 0;
    public int $ORDER = 1;
    public int $PAGINATE = 20;

    public function index()
    {
        $shops = Shop::all();
        $sales = Summary::where('type',$this->SALE)->orderBy('date','desc')->paginate($this->PAGINATE);
        $orders = Summary::where('type',$this->ORDER)->orderBy('date','desc')->paginate($this->PAGINATE);

        return response()->json([
            "shops"         => new ShopCollection($shops),
            "sales"         => new SummaryCollection($sales),
            "orders"         => new SummaryCollection($orders),
        ]);
    }
}
