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

/********************
* ROUTES - STATIC
********************/
Route::get('/', 'GameController@homepage')->name('home');

/********************
* ROUTES - PAGES
********************/
Route::get('page', 'PageController@index')->name('page.index');
Route::post('page', 'PageController@store')->name('page.store');
Route::get('page/create', 'PageController@create')->name('page.create');
Route::put('page/{id}', 'PageController@update')->name('page.update');
Route::delete('page/{id}', 'PageController@destroy')->name('page.destroy');
Route::get('page/{slug}/edit', 'PageController@edit')->name('page.edit');

/********************
* ROUTES - GAMES
********************/
Route::get('game', 'GameController@index')->name('game.index');
Route::post('game', 'GameController@store')->name('game.store');
Route::get('game/create', 'GameController@create')->name('game.create');
Route::get('rent-{game}', 'GameController@show')->name('game.show');
Route::put('game/{game}', 'GameController@update')->name('game.update');
Route::delete('game/{game}', 'GameController@destroy')->name('game.destroy');
Route::get('game/{game}/edit', 'GameController@edit')->name('game.edit');
Route::post('game/addtowishlist', 'GameController@addToWishlist')->name('game.addtowishlist');
Route::post('game/deletefromwishlist', 'GameController@deleteFromWishlist')->name('game.deletefromwishlist');

Route::any('rent-games/searchpost/', 'GameController@searchPost')->name('game.searchpost');
Route::get('search-games', 'GameController@search')->name('game.search');
Route::get('rent-games/{querystring}', 'GameController@search')->name('game.search');

/********************
* ROUTES - PLAN
********************/
Route::get('plan', 'PlanController@index');
Route::post('plan-store', 'PlanController@store')->name('plan.store');
Route::get('plan/{id}', 'PlanController@show')->name('plan.show');

/********************
* ROUTES - USER
********************/
Route::get('user/account', 'UserController@account')->name('user.account');
Route::post('user/accountupdate', 'UserController@accountUpdate')->name('user.accountupdate');
Route::get('user/history', 'UserController@history')->name('user.history');
Route::get('user/subscription', 'UserController@subscription')->name('user.subscription');
Route::post('user/subscription/cancel', 'UserController@cancelSubscription')->name('user.cancelsubscription');
Route::post('user/subscription/resume', 'UserController@resumeSubscription')->name('user.resumesubscription');
Route::resource('user', 'UserController');

/********************
* ROUTES - ADMIN
********************/
Route::get('admin/', 'AdminController@admin')->name('admin.admin');
Route::post('admin/assignment-run', 'AdminController@assignmentRun')->name('admin.assignmentrun');
Route::post('admin/confirm-assignments', 'AdminController@confirmassignments')->name('admin.confirmassignments');
Route::get('admin/printdeliverynote/{id}', 'AdminController@printDeliveryNote')->name('admin.printdeliverynote');
Route::get('admin/rentals', 'AdminController@rentals')->name('admin.rentals');
Route::post('admin/rentals-update', 'AdminController@rentalsUpdate')->name('admin.rentalsupdate');
Route::get('admin/send-games', 'AdminController@sendGames')->name('admin.sendgames');
Route::get('admin/stock/', 'AdminController@stockIndex')->name('admin.stockindex');
Route::get('admin/stock/{id}', 'AdminController@stock')->name('admin.stock');
Route::post('admin/stock-update', 'AdminController@stockUpdate')->name('admin.stockupdate');
Route::any('admin/users', 'AdminController@users')->name('admin.users');

/********************
* ROUTES - OTHER
********************/
Route::get('braintree/token', 'BraintreeTokenController@token');
Route::post(
    'braintree/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);

Auth::routes();
Route::get('log-out', 'Auth\LoginController@logout')->name('log-out');

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::get('sitemap', 'SitemapController@index')->name('sitemap');

Route::get('{slug}', 'PageController@show')->name('page.show');