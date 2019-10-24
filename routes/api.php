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

// categories
Route::get('categories', 'CategoryController@index')->name('api.categories.index');

// orders
Route::get('orders/{customer_id?}', 'OrderController@index')->name('api.orders.index')->middleware(\Barryvdh\Cors\HandleCors::class);
Route::post('orders', 'OrderController@store')->name('api.orders.store')->middleware(\Barryvdh\Cors\HandleCors::class);
Route::get('orders/{order_number}/details', 'OrderController@show')->name('api.orders.show')->middleware(\Barryvdh\Cors\HandleCors::class);

// products
Route::get('products/search', 'ProductController@search')->name('api.products.search');
Route::get('products/{id}/download', 'ProductController@download')->name('api.products.download');
Route::get('products/{category_slug?}', 'ProductController@index')->name('api.products.index')->middleware('cors', \Barryvdh\Cors\HandleCors::class);
Route::get('products/{id}', 'ProductController@show')->name('api.products.show')->middleware(\Barryvdh\Cors\HandleCors::class);

// pins
Route::get('pins/{pin}/check', 'PinController@check')->name('api.pins.check')->middleware(\Barryvdh\Cors\HandleCors::class);

// transactions
Route::post('transactions/pay/pin', 'TransactionController@pinPay')->name('api.transactions.pinPay')->middleware(\Barryvdh\Cors\HandleCors::class);
Route::post('transactions/pay/online', 'TransactionController@onlinePay')->name('api.transactions.onlinePay')->middleware(\Barryvdh\Cors\HandleCors::class);

// users
Route::post('/register', 'AuthController@register')->name('api.register');
Route::post('/login', 'AuthController@login')->name('api.login');
Route::post('/logout', 'AuthController@logout')->name('api.logout');

// customer
Route::put('/customer/{id}/update', 'CustomerController@updateCustomerInfo')->name('api.updateCustomerInfo');