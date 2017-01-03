<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::group(['middleware'  => 'auth'], function() {

    Route::get('/home', 'HomeController@index');

    Route::resource('notifications', 'NotificationController');

    Route::resource('chat', 'ChatController');
});