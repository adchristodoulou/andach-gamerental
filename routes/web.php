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


Route::get('/', 'GameController@homepage');

Route::resource('game', 'GameController');
Route::post('game/{id}/addtowishlist', 'GameController@addToWishlist')->name('game.addtowishlist');

Auth::routes();
Route::get('log-out', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/rent-games/{system}/{category}', 'GameController@search')->name('game.systemsearch');

Route::get('/rent-games/{system}', 'GameController@search')->name('game.systemsearch');

Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');