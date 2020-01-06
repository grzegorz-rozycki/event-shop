<?php

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


Route::group([
    'prefix' => 'carts',
], function () {
    Route::get('{cart}/items', 'Resources\CartItemController@index')
        ->where('cart', '\d+');
    Route::post('{cart}/items', 'Resources\CartItemController@store')
        ->where('cart', '\d+');
    Route::put('{cart}/items/{item}', 'Resources\CartItemController@update')
        ->where('cart', '\d+')
        ->where('item', '\d+');
    Route::delete('{cart}/items/{item}', 'Resources\CartItemController@destroy')
        ->where('cart', '\d+')
        ->where('item', '\d+');
});
