<?php

namespace App\Providers;

use App;
use App\Cart;
use App\Category;
use App\Game;
use App\ProductCategory;
use App\System;
use Auth;
use View;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Braintree_Configuration::environment(config('services.braintree.environment'));
        \Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
        \Braintree_Configuration::publicKey(config('services.braintree.public_key'));
        \Braintree_Configuration::privateKey(config('services.braintree.private_key'));

        $gamemenu = array();
        $categories = array();
        $numberofitemsincart = 0;
        $productCategories = array();

        if( !App::runningInConsole() ){
            Cashier::useCurrency('gbp', '£');

            //Share the systems for the drop-down menu on every page. 
            $systems  = Game::all()->pluck('system_id')->toArray();
            $systems  = array_flip(array_flip(array_filter($systems)));
            $gamemenu = System::whereIn('id', $systems)->orderBy('id', 'desc')->get();

            $categories = Category::all();

            $numberofitemsincart = Cart::myCartCount();

            $productCategories = ProductCategory::nested()->get();
        }

        View::share('gamemenu', $gamemenu);
        View::share('gamecategories', $categories);
        View::share('numberofitemsincart', $numberofitemsincart);
        View::share('productCategories', $productCategories);
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
