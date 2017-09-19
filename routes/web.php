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

Route::get('/about-us', function () { return view('pages.about-us'); });

Route::resource('game', 'GameController');
Route::post('game/addtowishlist', 'GameController@addToWishlist')->name('game.addtowishlist');
Route::post('game/deletefromwishlist', 'GameController@deleteFromWishlist')->name('game.deletefromwishlist');

Route::resource('user', 'UserController');
Route::get('account', 'UserController@account')->name('user.account');
Route::post('accountupdate', 'UserController@accountUpdate')->name('user.accountupdate');
Route::get('history', 'UserController@history')->name('user.history');

Auth::routes();
Route::get('log-out', 'Auth\LoginController@logout');

Route::get('/rent-games/{system}/{category}', 'GameController@search')->name('game.systemcategorysearch');
Route::get('/rent-games/{system}', 'GameController@search')->name('game.systemsearch');

Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::get('/admin/send-games', 'AdminController@sendGames')->name('admin.sendgames');
Route::get('/admin/stock', 'AdminController@stock')->name('admin.stock');
Route::post('/admin/stock-update', 'AdminController@stockUpdate')->name('admin.stockupdate');