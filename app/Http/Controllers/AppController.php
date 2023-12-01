<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ShopCollection;
use App\Http\Resources\SummaryCollection;
use App\Http\Resources\SummaryResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Summary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AppController extends Controller
{
    public int $SALE = 0;
    public int $ORDER = 1;
    public int $PAGINATE = 20;

    public function index()
    {
        $users = [];
        $user = User::find(Auth::id());

        if($user->hasRole('administrator')){
            $shops = Shop::all();
            $users = User::where('id',"!=",Auth::id())->orderBy("first_name","asc")->get();
        }else{
            $shops[] = $user->shop;
        }
        $categories = Category::orderBy("name","asc")->get();

        return response()->json([
            "shops"         => new ShopCollection($shops),
            "users"         => UserResource::collection($users),
            "categories"    => CategoryResource::collection($categories)
        ]);
    }

    public function getAuthUser(Request $request)
    {
        //API User
        $requestToken = substr($request->server('HTTP_AUTHORIZATION'), 7);

        if ($requestToken) {
            $token = PersonalAccessToken::findToken($requestToken);
            return $token->tokenable;
        } else
            return null;

    }

    public function generateUniqueCode()
    {
        do{
            $code=rand(100,999);
            //If the code exists generate another one
        }while(User::where('code',$code)->exists());

        //return unique code
        return $code;
    }

    public function seedProducts (Shop $shop)
    {
        $products = Product::all();
        foreach ($products as $product){
            Inventory::create([
                "shop_id"       =>  $shop->id,
                "product_id"    =>  $product->id,
                "stock"         =>  rand(0,20),
            ]);
        }
    }
}
