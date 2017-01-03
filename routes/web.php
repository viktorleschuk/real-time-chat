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

    Route::resource('chat', 'ChatController');

    Route::get('/im', [
        'uses'  =>  'ChatController@index',
        'as'    =>  'chat.im'
    ]);
});