<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function() {
    return 'hello world';
});

Route::post('login', 'Auth\LoginController@login')->name('login');

Route::middleware('auth:api')->post('/order', 'OrderController@get_data')->name('order');

Route::middleware('auth:api')->post('/order/delivery', 'OrderController@delivery')->name('order-delivery');
