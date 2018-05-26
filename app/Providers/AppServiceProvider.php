<?php

namespace App\Providers;

use App;
use App\Cart;
use App\Game;
use App\Genre;
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

        $gamemenu = array();
        $categories = array();
        $genres = array();
        $numberofitemsincart = 0;
        $productCategories = array();

        if( !App::runningInConsole() ){
            Cashier::useCurrency('gbp', '£');

            //Share the systems for the drop-down menu on every page. 
            $systems  = Game::all()->pluck('system_id')->toArray();
            $systems  = array_flip(array_flip(array_filter($systems)));
            $gamemenu = System::whereIn('id', $systems)->orderBy('id', 'desc')->get();

            $genres = Genre::orderBy('name')->get();

            $numberofitemsincart = Cart::myCartCount();

            $productCategories = ProductCategory::nested()->get();
        }

        View::share('gamemenu', $gamemenu);
        View::share('gamegenres', $genres);
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
