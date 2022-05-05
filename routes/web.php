<?php

Route::resource('book', 'App\Http\Controllers\BookController');

Route::get('hello', 'App\Http\Controllers\HelloController@index');

Route::post('hello', 'App\Http\Controllers\HelloController@post');

Route::get('board', 'App\Http\Controllers\BoardController@index');
Route::post('board', 'App\Http\Controllers\BoardController@create');


Route::get('board/add', 'App\Http\Controllers\BoardController@add');
Route::post('board/add', 'App\Http\Controllers\BoardController@create');