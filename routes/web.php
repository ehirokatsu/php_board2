<?php

Route::resource('book', 'App\Http\Controllers\BookController');

Route::get('hello', 'App\Http\Controllers\HelloController@index');

Route::post('hello', 'App\Http\Controllers\HelloController@post');
/*
Route::get('board', 'App\Http\Controllers\BoardController@index');

Route::post('board', 'App\Http\Controllers\BoardController@create');

Route::delete('board/{id}', 'App\Http\Controllers\BoardController@destroy');

Route::post('board/{id}', 'App\Http\Controllers\BoardController@destroy');

Route::get('board/{id}', 'App\Http\Controllers\BoardController@destroy');

Route::get('board/add', 'App\Http\Controllers\BoardController@add');

Route::post('board/add', 'App\Http\Controllers\BoardController@create');
*/

//showを制限しないと、board/replyにアクセスしたときにshowと判定されてしまう
Route::resource('board', 'App\Http\Controllers\boardController', 
['only' => ['index', 'show', 'create', 'edit', 'store', 'destroy', 'update']])->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('board/{id}/reply', 'App\Http\Controllers\BoardController@replyshow')->middleware('auth');

Route::post('board/reply', 'App\Http\Controllers\BoardController@replyStore')->middleware('auth');