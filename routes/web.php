<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'IndexController@index');

Route::resource('records', 'ItemsController');

Route::get('/atc/{id}', 'CartController@store');
Route::get('/atc/increase/{id}', 'CartController@increaseItem');
Route::get('/atc/decrease/{id}', 'CartController@decreaseItem');
Route::get('/atc/remove/{id}', 'CartController@removeItem');

Auth::routes(); // Creates the login, signup, etc routes.

Route::get('/viewcart', 'CartController@showCart');

Route::get('/checkout', 'CartController@checkout');

Route::get('/post_checkout', 'CartController@postCheckout');

Route::get('/vieworders', 'OrdersController@showOrders');

