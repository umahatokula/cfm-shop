<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('dashboard');
});


// dashboard
Route::get('dashboard', 'DashboardController@admin')->name('dashboard');

// users
Route::get('users/{id}/delete', 'UsersController@delete')->name('users.delete');
Route::resource('users', 'UsersController');

// bundles
Route::get('bundles/{id}/delete', 'BundleController@delete')->name('bundles.delete');
Route::resource('bundles', 'BundleController');

// order
Route::get('orders/{id}/delete', 'OrderController@delete')->name('orders.delete');
Route::resource('orders', 'OrderController');

// order details
Route::get('orders/{id}/details', 'OrderDetailController@details')->name('orders.details');

// products
Route::resource('products', 'ProductController');

// roles
Route::get('roles', 'RolesController@getRoles')->name('roles');

// home
Route::get('/home', 'HomeController@index')->name('home');

// auth
Auth::routes();
