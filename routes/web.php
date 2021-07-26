<?php

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Voyager Admin */
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::auth();


/* Landing Page */
Route::get('', 'LandingPageController@index');
Route::get('test', function() {
   return view('test');
});
Route::get('test2', function() {
    Auth::user()->notify(new \App\Notifications\GenericNotification('Build complete', 'Your build was completed Your build was completed  Your build was completed dsasad<a href="#">wazzuP</a>', 'success'));
//    event(new \App\Events\NotificationEvent(\Illuminate\Support\Facades\Auth::user(), 'Your build was complete', 'success'));
//    event( new \App\Events\BuildStatusChanged(\Illuminate\Support\Facades\Auth::user(), 'new'));
//    return 'done';
});
/* GeoMakeIt Studio */
Route::group([
    'prefix' => 'studio',
    'middleware' => ['auth'],
], function () {

    // TODO: Change this to actual home
    // Route::get('/', 'StudioController@index');
    Route::redirect('/', '/studio/games');
    /* Account */
    Route::get('/account', 'Auth\\AccountController@index')->name('studio.account');
    Route::post('/account', "Auth\\AccountController@updateAccount");

    /* Notifications */
    Route::post('/notifications/read', function() {
        \Illuminate\Support\Facades\Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success'=>'Success']);
    })->name('studio.notifications.read');

    /* Games */
    Route::resource('/games', 'GameController', ['as'=>'studio']);

    /* Game Plugins */
    Route::get('games/{game}/plugins', 'GamePluginController@index')->name('studio.games.plugins.index');
    Route::get('games/{game}/plugins/{plugin}', 'GamePluginController@show')->name('studio.games.plugins.show');
    Route::post('games/{game}/plugins/{plugin}/install', 'GamePluginController@install')->name('studio.games.plugins.install');
    Route::delete('games/{game}/plugins/{plugin}', 'GamePluginController@destroy')->name('studio.games.plugins.destroy');

    /* Game Plugin Data */
    Route::post('games/{game}/plugins/{plugin}/data/{data}', 'Games\\Plugins\\DataController@store')->name('studio.games.plugins.data.store');

    /* Game Plugin Configs */
    Route::post('games/{game}/plugins/{plugin}/config/{file_name}', 'GamePluginConfigController@update')->name('studio.games.plugins.configs.update');


    /* Game Builder */
    Route::get('games/{game}/builder', 'Games\\BuilderController@index')->name('studio.games.builder.index');
    Route::post('games/{game}/builder/build', 'Games\\BuilderController@build')->name('studio.games.builder.build');
    Route::get('games/{game}/builder/build', function($game){ return redirect()->route('studio.games.builder.index', [$game]); });
    Route::post('games/{game}/builder/download', 'Games\\BuilderController@download')->name('studio.games.builder.download');
    Route::get('games/{game}/builder/download', function($game){ return redirect()->route('studio.games.builder.index', [$game]); });

//    Route::get('games/{game}/plugins/showcase', 'GamePluginController@index')->name('games.plugins');

    /* Plugins */
    Route::resource('/plugins', 'PluginController', ['as'=>'studio'])->except(
        ['show']
    );
    Route::post('plugins/{plugin}/restore', 'PluginController@restore')->name('studio.plugins.restore');
    Route::delete('plugins/{plugin}/forceDelete', 'PluginController@forceDelete')->name('studio.plugins.forceDelete');
//    Route::get('plugins/showcase', 'PluginController@showcase')->name('plugins.showcase');
//    Route::get('plugins/{plugin}/dl', 'PluginController@download')->name('plugins.download');
//    Route::delete('plugins/{plugin}/forceDelete', 'PluginController@forceDelete')->name('plugins.forceDelete');
//    Route::post('plugins/{plugin}/restore', 'PluginController@restore')->name('plugins.restore');
//    Route::get('plugins/{plugin}/deleteSource', 'PluginController@deleteSource'); // TODO: REMOVE THIS

});

/* Development only */
Route::get('/build/{game}', function($game) {
    return \App\Jobs\AssembleGame::dispatchNow(\App\Models\Game::find($game));
});
Route::get('/download/{game}', function($game) {
    return \App\Models\Game::find($game)->download_release();
});
