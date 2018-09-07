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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['prefix' => 'v1'], function () {
    Route::get('users/password/reset/{token}', ['as' => 'get_reset_user', 'uses' => 'Auth\ResetPasswordController@get_reset_password_user']);

    Route::group(['middleware' => 'api.version'], function () {
        Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@store']);
        Route::post('login', ['as' => 'getLogin', 'uses' => 'Auth\LoginController@getLogin']);

        Route::post('users/password/reset', ['as' => 'get_reset_password_link', 'uses' => 'Auth\ForgotPasswordController@get_reset_password_link']);
        Route::put('users/password/reset/{token}', ['as' => 'do_reset_password', 'uses' => 'Auth\ResetPasswordController@do_reset_password']);

        Route::group(['middleware' => 'jwt-auth'], function () {
            Route::post('game', ['as' => 'createGame', 'uses' => 'Api\GameController@createGame']);
            Route::get('game', ['as' => 'getGame', 'uses' => 'Api\GameController@getGame']);
        });
    });
});
