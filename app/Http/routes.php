<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'HomeController@index');
Route::get('/', 'NotLoggedIn@index');

Route::any('/sms','SMSController@receive');
Route::any('/sms/test','SMSController@test');
Route::get('home', 'HomeController@index');
Route::any('user/phoneNumber','UserController@phoneNumber');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);