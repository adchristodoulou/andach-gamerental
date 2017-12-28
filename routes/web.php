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
//Because we might want to create a static page starting with "rent-", we have provision in the GameController@show method to push any unfound games to the appropriate PageController@show function. 
Route::get('rent-{game}', 'GameController@show')->name('game.show');
Route::get('achievements-{game}', 'GameController@achievements')->name('game.achievements');
Route::put('game/{game}', 'GameController@update')->name('game.update');
Route::delete('game/{game}', 'GameController@destroy')->name('game.destroy');
Route::get('game/{game}/edit', 'GameController@edit')->name('game.edit');
Route::post('game/addtowishlist', 'GameController@addToWishlist')->name('game.addtowishlist');
Route::post('game/deletefromwishlist', 'GameController@deleteFromWishlist')->name('game.deletefromwishlist');
Route::get('search-games', 'GameController@search')->name('game.search');

/********************
* ROUTES - PLAN
********************/
Route::get('plan', 'PlanController@index')->name('plan.index');
Route::post('plan-store', 'PlanController@store')->name('plan.store');
Route::get('plan/{slug}', 'PlanController@show')->name('plan.show');

/********************
* ROUTES - PRODUCTS
********************/
Route::get('cart', 'ProductController@cart')->name('product.cart');
Route::get('cart2', 'ProductController@cart2')->name('product.cart2');
Route::post('cart3', 'ProductController@cart3')->name('product.cart3');
Route::post('cart4', 'ProductController@cart4')->name('product.cart4');
Route::post('cart', 'ProductController@cartPost')->name('product.cartpost');
Route::get('product', 'ProductController@index')->name('product.index');
Route::post('product/addtocart', 'ProductController@addToCart')->name('product.addtocart');
Route::get('{slug}-buy', 'ProductController@show')->name('product.show');
Route::get('{slug}-category', 'ProductController@showcategory')->name('product.showcategory');

/********************
* ROUTES - USER
********************/
Route::get('user/account', 'UserController@account')->name('user.account');
Route::post('user/accountupdate', 'UserController@accountUpdate')->name('user.accountupdate');
Route::get('user/edit', 'UserController@edit')->name('user.edit');
Route::get('user/history', 'UserController@history')->name('user.history');
Route::get('user/invoice/{id}', 'UserController@invoiceShow')->name('user.invoiceshow');
Route::get('user/invoices', 'UserController@invoiceList')->name('user.invoicelist');
Route::get('user/subscription', 'UserController@subscription')->name('user.subscription');
Route::post('user/subscription/cancel', 'UserController@cancelSubscription')->name('user.cancelsubscription');
Route::post('user/subscription/resume', 'UserController@resumeSubscription')->name('user.resumesubscription');
Route::put('user/update', 'UserController@update')->name('user.update');
Route::post('user/register', 'UserController@registerPost')->name('user.register');
Route::get('user/registeraddress', 'UserController@registerAddress')->name('user.registeraddress');

/********************
* ROUTES - ADMIN
********************/
Route::get('admin/', 'AdminController@admin')->name('admin.admin');
Route::post('admin/assignment-run', 'AdminController@assignmentRun')->name('admin.assignmentrun');
Route::post('admin/confirm-assignments', 'AdminController@confirmassignments')->name('admin.confirmassignments');
Route::get('admin/games', 'AdminController@gameIndex')->name('admin.gameindex');
Route::post('admin/games-post', 'AdminController@gameIndexPost')->name('admin.gameindexpost');
Route::get('admin/igdb/{name}', 'AdminController@IGDBSearch')->name('admin.igdbsearch');
Route::get('admin/printdeliverynote/{id}', 'AdminController@printDeliveryNote')->name('admin.printdeliverynote');
Route::get('admin/product/create/', 'AdminController@productCreate')->name('admin.productcreate');
Route::get('admin/product/edit/{id}', 'AdminController@productEdit')->name('admin.productedit');
Route::get('admin/product/', 'AdminController@productIndex')->name('admin.productindex');
Route::post('admin/product/', 'AdminController@productStore')->name('admin.productstore');
Route::put('admin/product/', 'AdminController@productUpdate')->name('admin.productupdate');
Route::get('admin/rentals', 'AdminController@rentals')->name('admin.rentals');
Route::post('admin/rentals-update', 'AdminController@rentalsUpdate')->name('admin.rentalsupdate');
Route::get('admin/send-games', 'AdminController@sendGames')->name('admin.sendgames');
Route::get('admin/stock/', 'AdminController@stockIndex')->name('admin.stockindex');
Route::get('admin/stock/{id}', 'AdminController@stock')->name('admin.stock');
Route::post('admin/stock-update', 'AdminController@stockUpdate')->name('admin.stockupdate');
Route::get('admin/upload-stock', 'AdminController@uploadStock')->name('admin.uploadstock');
Route::post('admin/upload-stock-post', 'AdminController@uploadStockPost')->name('admin.uploadstockpost');
Route::any('admin/users', 'AdminController@users')->name('admin.users');

/********************
* ROUTES - CONTACT
********************/
Route::get('contact', 'ContactController@create')->name('contact.create');
Route::get('contact/attachment/{slug}', 'ContactController@attachment')->name('contact.attachment');
Route::post('contact/send', 'ContactController@store')->name('contact.store');
Route::get('contact/show/{id}', 'ContactController@show')->name('contact.show');
Route::post('contact/update/', 'ContactController@update')->name('contact.update');

/********************
* ROUTES - OTHER
********************/
Route::get('braintree/token', 'BraintreeTokenController@token');
Route::post('braintree/webhook', 'WebhookController@handleWebhook');

Auth::routes();
Route::get('log-out', 'Auth\LoginController@logout')->name('log-out');

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::get('sitemap', 'SitemapController@index')->name('sitemap');

Route::get('{slug}', 'PageController@show')->name('page.show');