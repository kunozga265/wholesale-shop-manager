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
}
