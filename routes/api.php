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
            Route::get('game/{id}', ['as' => 'getSingleGame', 'uses' => 'Api\GameController@getSingleGame']);
            Route::get('searchGame', ['as' => 'searchGame', 'uses' => 'Api\GameController@searchGame']);
            Route::post('game/{id}', ['as' => 'editGame', 'uses' => 'Api\GameController@editGame']);
            Route::delete('game/{id}', ['as' => 'deleteGame', 'uses' => 'Api\GameController@deleteGame']);

            Route::post('team', ['as' => 'createTeam', 'uses' => 'Api\TeamController@createTeam']);
            Route::get('team', ['as' => 'getTeam', 'uses' => 'Api\TeamController@getTeam']);
            Route::get('team/{id}', ['as' => 'getSingleTeam', 'uses' => 'Api\TeamController@getSingleTeam']);
            Route::get('searchTeam', ['as' => 'searchTeam', 'uses' => 'Api\TeamController@searchTeam']);
            Route::post('team/{id}/{game_id}', ['as' => 'editTeam', 'uses' => 'Api\TeamController@editTeam']);
            Route::delete('team/{id}', ['as' => 'deleteTeam', 'uses' => 'Api\TeamController@deleteTeam']);

            Route::post('player', ['as' => 'createPlayer', 'uses' => 'Api\PlayerController@createPlayer']);
            Route::get('player', ['as' => 'getPlayer', 'uses' => 'Api\PlayerController@getPlayer']);
            Route::get('player/{id}', ['as' => 'getSinglePlayer', 'uses' => 'Api\PlayerController@getSinglePlayer']);
            Route::get('searchPlayer', ['as' => 'searchPlayer', 'uses' => 'Api\PlayerController@searchPlayer']);
            Route::post('player/{id}/{team_id}', ['as' => 'editPlayer', 'uses' => 'Api\PlayerController@editPlayer']);
            Route::delete('player/{id}', ['as' => 'deletePlayer', 'uses' => 'Api\PlayerController@deletePlayer']);
        });
    });
});
