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

// orders
Route::get('orders', 'OrderController@index')->name('api.orders.index');
Route::post('orders', 'OrderController@store')->name('api.orders.store');
Route::get('orders/{id}', 'OrderController@show')->name('api.orders.show');

// products
Route::get('products', 'ProductController@index')->name('api.products.index');;
Route::get('products/{id}', 'ProductController@show')->name('api.products.show');