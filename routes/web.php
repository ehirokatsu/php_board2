<?php

Route::get('board/profile', 'App\Http\Controllers\BoardController@profile')->middleware('auth');
Route::PUT('board/profile', 'App\Http\Controllers\BoardController@profileUpdate')->middleware('auth');

Route::DELETE('board/profile', 'App\Http\Controllers\BoardController@profileDelete')->middleware('auth');

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

Route::get('board/{id}/reply', 'App\Http\Controllers\BoardController@replyShow')->middleware('auth');

Route::post('board/reply', 'App\Http\Controllers\BoardController@replyStore')->middleware('auth');

