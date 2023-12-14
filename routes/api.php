<?php

use App\Http\Controllers\SummaryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/products/seeder', [\App\Http\Controllers\ProductController::class,'seeder']);

Route::post("/users/login",[UserController::class,'login']);

//Authenticated Routes
Route::group(["middleware"=>["auth:sanctum","roles"]],function (){

    Route::get("/dashboard",[
        "uses" => "App\Http\Controllers\AppController@index",
    ]);

    Route::post("/users/register", [
            "uses" => "App\Http\Controllers\UserController@register",
            'roles' =>['administrator']
    ]);

    // Inventory
    Route::group(["prefix"=>"inventory"],function () {

        Route::post("/{id}", [
            "uses" => "App\Http\Controllers\InventoryController@update",
            'roles' => ['administrator']
        ]);

        Route::post("/", [
            "uses" => "App\Http\Controllers\InventoryController@store",
            'roles' => ['administrator']
        ]);
    });

    //Shops
    Route::group(["prefix"=>"shops"],function (){

        Route::get("/", [
            "uses" => "App\Http\Controllers\ShopController@index",
        ]);

        Route::post("/", [
            "uses"  => "App\Http\Controllers\ShopController@store",
            'roles' => ['administrator']
        ]);

        Route::post("/{id}", [
            "uses"  => "App\Http\Controllers\ShopController@update",
            'roles' => ['administrator']
        ]);
    });

    //Summaries
    Route::group(["prefix"=>"summaries"],function (){

        Route::get("/{shop_id}/{start_date}/{end_date}", [
            "uses" => "App\Http\Controllers\SummaryController@index",
        ]);

        Route::post("/", [
            "uses" => "App\Http\Controllers\SummaryController@store",
        ]);

        Route::post("/{id}", [
            "uses" => "App\Http\Controllers\SummaryController@update",
        ]);
    });

    //Expenses
    Route::group(["prefix"=>"expenses"],function (){

        Route::get("/{shop_id}", [
            "uses" => "App\Http\Controllers\ExpenseController@index",
            'roles' => ['administrator']
        ]);

        Route::post("/", [
            "uses"  => "App\Http\Controllers\ExpenseController@store",
            'roles' => ['administrator']
        ]);

        Route::post("/{id}", [
            "uses"  => "App\Http\Controllers\ExpenseController@update",
            'roles' => ['administrator']
        ]);
    });
});
