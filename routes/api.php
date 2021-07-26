<?php


use Illuminate\Support\Facades\Route;

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

// Users apis
Route::prefix('/users')
    ->group(function () {
        Route::get('/all', 'UsersController@GetAllUsers');
        Route::put('/update/{id}', 'UsersController@UpdateUser');
        Route::post('/new', 'UsersController@NewUser');
        Route::delete('/delete/{id}', 'UsersController@DeleteUser');
        Route::get('/status', 'UsersController@isUserOnline');
        Route::get('/{id}', 'UsersController@GetUserById');
       // Route::post('/check/username', 'UsersController@CheckIfUserNameExists');
        Route::post('/check/email', 'UsersController@CheckIfEmailExists');
    });

// Games apis
Route::prefix('/games')
    ->group(function () {
        Route::get('/user/{userId}', 'GameController@GetAllGamesByUserId');
        Route::post('/new', 'GameController@NewGameForUser');
        Route::get('/id/{id}', 'GameController@GetGameById');
        Route::put('/update/{id}', 'GameController@UpdateGame');
        Route::delete('/delete/{id}', 'GameController@DeleteGame');
        Route::get('/all', 'GameController@GetAllGames');
        Route::get('/plugins/{id}', 'GamePluginsController@GetAllPluginsByGameId');
        Route::post('/addPlugin', 'GamePluginsController@AddPluginToGame');
        Route::delete('/deletePlugin', 'GamePluginsController@DeletePluginFromGame');
    });
