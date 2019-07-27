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

// roles
Route::get('roles', 'RolesController@getRoles')->name('roles');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
