<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "code"         => ['required'],
            "password"     => ['required'],
            'device_name'  => ['required'],
        ]);

        $user = User::where('code', $request->code)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'code' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token=$user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'user'  =>  new UserResource($user),
            'token' =>  $token
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            "first_name"     => ['required','string', 'max:255'],
            "last_name"      => ['required','string', 'max:255'],
//            'device_name'   => ['required'],
            'password'       => ['required','confirmed'],
            'role_id'       => ['required'],
//            'shop_id'       => ['required'],
        ]);

        $user=User::create([
            "first_name"    => ucwords($request->first_name),
            "last_name"     => ucwords($request->last_name),
            "shop_id"       => $request->shop_id,
            "code"          => (new AppController())->generateUniqueCode(),
            "password"      => bcrypt($request->password),
        ]);

        $user->roles()->attach([$request->role_id]);

//        $token=$user->createToken($request->device_name)->plainTextToken;

        //Run notifications

        return response()->json(
            /*'user'  =>  */new UserResource($user)
//            'token' =>  $token
        );
    }
}
