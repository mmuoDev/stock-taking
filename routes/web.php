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
use Illuminate\Support\Facades\Auth;
use App\Libraries\Utilities;
use App\User;

Route::get('/', function () {
    return view('welcome');
    //dd(Auth::user()->id);
});
Route::get('/home', 'HomeController@index');
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
//Route::get('/', 'HomeController@index')->name('home');
//Items route
Route::group(['prefix' => 'items'], function(){
    Route::match(['post', 'get'], '/', 'ItemController@index')->name('items');
    Route::match(['post', 'get'], '/add', 'ItemController@add_item');
});
Route::group(['prefix' => 'stocks'], function (){
    Route::match(['post', 'get'], '/', 'StockController@index');
    Route::match(['post', 'get'], 'requests/{id}', 'StockController@view_requests');
});
Route::group(['prefix' => 'requests'], function (){
    Route::match(['post', 'get'], '/request/{uri}', 'RequestController@get_request');
    Route::match(['post', 'get'], '/new', 'RequestController@new_request');
    Route::match(['post', 'get'], '/', 'RequestController@index')->name('requests');
});
Route::group(['prefix' => 'settings'], function(){
    Route::match(['post', 'get'], '/category', 'CategoryController@index');
    Route::match(['post', 'get'], '/category/create', 'CategoryController@create');
    Route::post('/category/update', 'CategoryController@update');
});
Route::group(['prefix' => 'users'], function (){
   Route::match(['post', 'get'], '/', 'UserController@index')->name('users');
   Route::match( ['post','get'],'/edit', 'UserController@edit_user');
   Route::match( ['post','get'],'/add-user', 'UserController@add_user');
   Route::match(['post','get'], 'change-password', 'PasswordController@change_password');
});
Route::get('notifications/markAsRead/{id}', 'NotificationsController@markAsRead');
