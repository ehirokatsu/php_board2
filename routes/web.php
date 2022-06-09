<?php
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/user', 'App\Http\Controllers\UserController@user');

    Route::put('/user', 'App\Http\Controllers\UserController@userUpdate');

    Route::delete('/{id}/user', 'App\Http\Controllers\UserController@userDestroy')->where('id', '[0-9]+');

    Route::get('/', 'App\Http\Controllers\BoardController@index');

    Route::get('/{id}', 'App\Http\Controllers\BoardController@show')->where('id', '[0-9]+');

    Route::get('/create', 'App\Http\Controllers\BoardController@create');

    Route::post('/', 'App\Http\Controllers\BoardController@store');

    Route::get('/{id}/edit', 'App\Http\Controllers\BoardController@edit')->where('id', '[0-9]+');

    Route::put('/{id}', 'App\Http\Controllers\BoardController@update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'App\Http\Controllers\BoardController@destroy')->where('id', '[0-9]+');

    Route::get('/{id}/replyShow', 'App\Http\Controllers\BoardController@replyShow')->where('id', '[0-9]+');

    Route::post('/replyStore', 'App\Http\Controllers\BoardController@replyStore');
});
/*
Route::get('/home', 'App\Http\Controllers\HomeController@index');

Route::resource('/', 'App\Http\Controllers\boardController', 
['only' => ['index', 'show', 'create', 'edit', 'store', 'destroy', 'update']])->middleware('auth');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

