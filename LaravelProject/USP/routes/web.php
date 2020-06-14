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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes([
    'register' => true,
    'verify' => true,
    'reset' => true
]);


Route::middleware('verified')->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/user/products', 'UserController@getMyProducts')->name('user_products');


    Route::get('/cart/{id}', 'UserController@getCart')->name('cart.show');

    Route::post('/buy', 'UserController@putInCart')->name('cart.addToCart');
    Route::post('/cancel', 'UserController@cancelProduct')->name('product.cancel');
    Route::post('/cancel/{id}', 'UserController@cancelCart')->name('cart.cancel');
    Route::post('/cart/confirm/{id}', 'UserController@buyAllItems')->name('cart.buyAll');
    Route::post('/cart/buyItem', 'UserController@buyItem')->name('item.buy');

});

Route::post('/restful/login', 'RestfulController@userExists');
