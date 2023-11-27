<?php

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

Route::post('/products/seeder', [\App\Http\Controllers\ProductController::class,'store']);

// Inventory
Route::post('/inventory/{id}', [\App\Http\Controllers\InventoryController::class,'update']);

//Summaries
Route::post('/summaries/{id}', [\App\Http\Controllers\SummaryController::class,'update']);
Route::get('/summaries', [\App\Http\Controllers\SummaryController::class,'index']);
Route::post('/summaries', [\App\Http\Controllers\SummaryController::class,'store']);


//Shops
Route::get('/shops', [\App\Http\Controllers\ShopController::class,'index']);
