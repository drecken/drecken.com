<?php

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

Route::get('/logout', 'MainController@logout')->name('logout');
Route::get('twitch', 'TwitchController@twitch')->name('twitch');
Route::get('twitch/callback', 'TwitchController@callback')->name('twitch-callback');

Route::middleware('check-token')->group(function () {
    Route::get('/', 'MainController@index')->name('index');
});
Route::middleware(['auth', 'check-token'])->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
});

