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

Route::get('/plan', 'PlanController@index');
Route::post('/subscribe', 'PlanController@store')->name('plan.subscribe');
Route::get('/plan/{id}', 'PlanController@show');

Route::get('user/account', 'UserController@account')->name('user.account');
Route::post('user/accountupdate', 'UserController@accountUpdate')->name('user.accountupdate');
Route::get('user/history', 'UserController@history')->name('user.history');
Route::get('user/subscription', 'UserController@subscription')->name('user.subscription');
Route::resource('user', 'UserController');

Auth::routes();
Route::get('log-out', 'Auth\LoginController@logout');

Route::get('/rent-games/{system}/{category}', 'GameController@search')->name('game.systemcategorysearch');
Route::get('/rent-games/{system}', 'GameController@search')->name('game.systemsearch');

Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::get('/admin/send-games', 'AdminController@sendGames')->name('admin.sendgames');
Route::get('/admin/stock', 'AdminController@stock')->name('admin.stock');
Route::post('/admin/stock-update', 'AdminController@stockUpdate')->name('admin.stockupdate');

Route::get('/braintree/token', 'BraintreeTokenController@token');
Route::post(
    'braintree/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);