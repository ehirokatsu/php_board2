<?php
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/user/{id}/edit', 'App\Http\Controllers\Auth\RegisterController@edit')->where('id', '[0-9]+');;
 
    Route::get('/user/{id}', 'App\Http\Controllers\Auth\RegisterController@update')->where('id', '[0-9]+');;
    Route::put('/user/{id}', 'App\Http\Controllers\Auth\RegisterController@update')->where('id', '[0-9]+');;

    Route::delete('/user/{id}', 'App\Http\Controllers\Auth\RegisterController@destroy')->where('id', '[0-9]+');


    Route::get('/', 'App\Http\Controllers\BoardController@index');

    Route::get('/{id}', 'App\Http\Controllers\BoardController@show')->where('id', '[0-9]+');

    Route::get('/create', 'App\Http\Controllers\BoardController@create');

    Route::post('/', 'App\Http\Controllers\BoardController@store');

    Route::get('/{id}/edit', 'App\Http\Controllers\BoardController@edit')->where('id', '[0-9]+');

    Route::put('/{id}', 'App\Http\Controllers\BoardController@update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'App\Http\Controllers\BoardController@destroy')->where('id', '[0-9]+');

    Route::get('/{id}/replyShow', 'App\Http\Controllers\BoardController@replyShow')->where('id', '[0-9]+');

    Route::post('/replyStore', 'App\Http\Controllers\BoardController@replyStore');

    Route::get('/search', 'App\Http\Controllers\BoardController@search');


});
