<?php
Auth::routes();
Route::get('/profile', 'App\Http\Controllers\UserController@profile')->middleware('auth');
Route::put('/profile', 'App\Http\Controllers\UserController@profileUpdate')->middleware('auth');

Route::delete('/{id}/profile', 'App\Http\Controllers\UserController@profileDestroy')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//{id}より前に記載すること
Route::get('/create', 'App\Http\Controllers\BoardController@create')->middleware('auth');

Route::get('/', 'App\Http\Controllers\BoardController@index')->middleware('auth');

Route::get('/{id}', 'App\Http\Controllers\BoardController@show')->middleware('auth');


Route::post('/', 'App\Http\Controllers\BoardController@store')->middleware('auth');

Route::get('/{id}/edit', 'App\Http\Controllers\BoardController@edit')->middleware('auth');

Route::put('/{id}', 'App\Http\Controllers\BoardController@update')->middleware('auth');

Route::delete('/{id}', 'App\Http\Controllers\BoardController@destroy')->middleware('auth');

/*
Route::get('/home', 'App\Http\Controllers\HomeController@index');

Route::resource('/', 'App\Http\Controllers\boardController', 
['only' => ['index', 'show', 'create', 'edit', 'store', 'destroy', 'update']])->middleware('auth');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
Route::get('/{id}/replyShow', 'App\Http\Controllers\BoardController@replyShow')->middleware('auth');

Route::post('/replyStore', 'App\Http\Controllers\BoardController@replyStore')->middleware('auth');
