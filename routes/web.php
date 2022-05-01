<?php

Route::resource('book', 'App\Http\Controllers\BookController');

Route::get('hello', 'App\Http\Controllers\HelloController@index');

Route::post('hello', 'App\Http\Controllers\HelloController@post');

Route::get('/', 'App\Http\Controllers\BulletinboardController@index');

