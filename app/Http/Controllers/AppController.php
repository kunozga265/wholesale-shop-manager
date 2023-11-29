<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopCollection;
use App\Http\Resources\SummaryCollection;
use App\Http\Resources\SummaryResource;
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
        $shop = [];
        $user = User::find(Auth::id());
        if($user->hasRole('administrator')){
            $shops = Shop::all();
        }else{
            $shops[] = $user->shop;
        }


//        $sales = Summary::where('type',$this->SALE)->orderBy('date','desc')->paginate($this->PAGINATE);
//        $orders = Summary::where('type',$this->ORDER)->orderBy('date','desc')->paginate($this->PAGINATE);

        return response()->json([
            "shops" => new ShopCollection($shops),
//            "sales"         => new SummaryCollection($sales),
//            "orders"         => new SummaryCollection($orders),
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
}
