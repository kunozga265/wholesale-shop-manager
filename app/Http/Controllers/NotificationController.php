<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
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
