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
});

Auth::routes(['verify' => true]);

Route::middleware('verified')->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/user/products', 'UserController@getMyProducts')->name('user_products');
    Route::post('/buy/{id}', 'UserController@buyItem');

});

Route::post('/restful/login', 'RestfulController@userExists');
