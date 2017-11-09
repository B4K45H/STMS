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
    return view('welcome');
});
//licence
Route::get('/licence', 'LoginController@licence')->name('licence');
Route::get('/under-construction', 'LoginController@underConstruction')->name('under-construction');

Route::group(['middleware' => 'is.guest'], function() {
    Route::get('/', 'LoginController@publicHome')->name('public-home');
    //user validity expired
    Route::get('/user/expired', 'LoginController@userExpired')->name('user-expired');

    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/login/action', 'LoginController@loginAction')->name('login-action');
});