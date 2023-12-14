<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());

        if($user->hasRole('administrator')){
            $notifications = Notification::latest()->get();

        }else{
            $notifications = $user->notifications()->latest()->get();
        }

        return response()->json(NotificationResource::collection($notifications));
    }

    public function byShop($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);
        $notifications = $shop->notifications()->latest()->get();
        return response()->json(NotificationResource::collection($notifications));
    }

    public function byUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $notifications = $user->notifications()->latest()->get();
        return response()->json(NotificationResource::collection($notifications));
    }


    public function notify(string $type, string $message, $product_id = null, $shop_id = null, $user_id = null)
    {
        Notification::create([
           "type"       => $type,
           "message"    => $message,
           "product_id" => $product_id,
           "shop_id"    => $shop_id,
           "user_id"    => $user_id,
        ]);

        //push notification
    }
}
