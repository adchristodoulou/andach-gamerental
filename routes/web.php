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
Route::post('/plan-store', 'PlanController@store')->name('plan.store');
Route::get('/plan/{id}', 'PlanController@show')->name('plan.show');

Route::get('user/account', 'UserController@account')->name('user.account');
Route::post('user/accountupdate', 'UserController@accountUpdate')->name('user.accountupdate');
Route::get('user/history', 'UserController@history')->name('user.history');
Route::get('user/subscription', 'UserController@subscription')->name('user.subscription');
Route::post('user/subscription/cancel', 'UserController@cancelSubscription')->name('user.cancelsubscription');
Route::post('user/subscription/resume', 'UserController@resumeSubscription')->name('user.resumesubscription');
Route::resource('user', 'UserController');

Auth::routes();
Route::get('log-out', 'Auth\LoginController@logout')->name('log-out');

Route::get('/rent-games/{system}/{category}', 'GameController@search')->name('game.systemcategorysearch');
Route::get('/rent-games/{system}', 'GameController@search')->name('game.systemsearch');

Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::get('/admin/', 'AdminController@admin')->name('admin.admin');
Route::post('/admin/assignment-run', 'AdminController@assignmentRun')->name('admin.assignmentrun');
Route::post('/admin/confirm-assignments', 'AdminController@confirmassignments')->name('admin.confirmassignments');
Route::get('/admin/rentals', 'AdminController@rentals')->name('admin.rentals');
Route::post('/admin/rentals-update', 'AdminController@rentalsUpdate')->name('admin.rentalsupdate');
Route::get('/admin/send-games', 'AdminController@sendGames')->name('admin.sendgames');
Route::get('/admin/stock/', 'AdminController@stockIndex')->name('admin.stockindex');
Route::get('/admin/stock/{id}', 'AdminController@stock')->name('admin.stock');
Route::post('/admin/stock-update', 'AdminController@stockUpdate')->name('admin.stockupdate');
Route::any('/admin/users', 'AdminController@users')->name('admin.users');

Route::get('/braintree/token', 'BraintreeTokenController@token');
Route::post(
    'braintree/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);