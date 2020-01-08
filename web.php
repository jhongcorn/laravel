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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/{tourism?}','IndexControllers@index');

Route::get('citylink/{citylink}/{pageNum?}','IndexControllers@citylink');

Route::get('tourism/{dbtable}/{table_Id}/{tourism_Id}','IndexControllers@tourism');

Route::post('Search/Keywords','SearchControllers@search');

Route::any('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::any('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('user/new_password', 'Auth\UserControllers@new_password');

Route::any('user/register', 'Auth\UserControllers@register');
Route::any('user/email', 'Auth\UserControllers@email');
Route::any('user/login', 'Auth\UserControllers@login');
Route::post('user/forget_password','Auth\UserControllers@forget_password');

Route::group(['middleware' => ['web','user.login']], function () {
    Route::get('user/info','Auth\UserControllers@userinfo');
    Route::get('user/logout', 'Auth\LoginController@logout');
    Route::any('user/Order/{pageNum?}','Auth\UserControllers@order');
    Route::post('user/upload', 'Auth\UserControllers@upload');
    Route::post('user/update', 'Auth\UserControllers@update');
    Route::post('user/booking','Auth\UserControllers@booking_room');
    Route::any('user/Change_Order','Auth\UserControllers@Change_Order');
});

//  Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
