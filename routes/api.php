<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResource('books', 'BookController');
    Route::get('books/search', 'BookController@search');
});
