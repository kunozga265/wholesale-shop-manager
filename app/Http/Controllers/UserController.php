<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($user->hasAnyRole(["disabled"])){
            return response()->json(["message" => "Access Denied"],400);
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

    public function changePassword(Request $request)
    {
        $request->validate([
            'password'       => ['required','confirmed'],
        ]);
        $user = User::find(Auth::id());
        $user->update([
            "password"      => bcrypt($request->password),
        ]);
        return response()->json(["message"=>"Successfully changed password"]);
    }

    public function resetPassword($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->update([
            "password"      => bcrypt("12345678"),
        ]);
        return response()->json(["message"=>"Successfully changed password"]);
    }

    public function disableUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->roles()->detach();

        $role = Role::where("name","disabled")->first();
        $user->roles()->attach($role);

        (new NotificationController())->notify("USER_DISABLED", $user->first_name." ".$user->last_name." has been disabled. They no longer have access to the system", user_id: Auth::id());
        return response()->json(["message"=>"Successfully disabled user"]);
    }

    public function enableUser(Request $request, $user_id)
    {
        $request->validate([
            'role_id'       => ['required'],
        ]);

        $user = User::findOrFail($user_id);
        $user->roles()->attach([$request->role_id]);
        (new NotificationController())->notify("USER_ENABLED", $user->first_name." ".$user->last_name." has been enabled. They now have access to the system", user_id: Auth::id());
        return response()->json(["message"=>"Successfully enabled user"]);
    }


}
