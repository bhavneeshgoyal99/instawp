<?php

use App\Http\Controllers\Api\OrderCookiesController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserAuthController::class, 'login']);

Route::post('balance', [WalletController::class, 'addBalance'])->middleware('auth:api');
Route::get('balance', [WalletController::class, 'getbalance'])->middleware('auth:api');

Route::post('purchase-cookies', [OrderCookiesController::class, 'orderCookies'])->middleware('auth:api');
