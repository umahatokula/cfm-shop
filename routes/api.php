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

//List all categories
Route::get('categories', 'CategoryController@index');

//List single category
Route::get('category/{id}', 'CategoryController@show');

//Create new category
Route::post('category', 'CategoryController@store');

//Update category
Route::put('category', 'CategoryController@store');

//Delete category
Route::delete('category/{id}', 'CategoryController@destroy');

//Change category status
Route::put('category/status/{id}', 'CategoryController@changeStatus');

//List all orders
Route::get('orders', 'OrderController@index');

//Create new order
Route::post('orders', 'OrderController@store');

//List Single order
Route::get('orders/{id}', 'OrderController@show');