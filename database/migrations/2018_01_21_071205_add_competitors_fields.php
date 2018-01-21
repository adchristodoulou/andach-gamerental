<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompetitorsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->string('name')->nullable();
            $table->text('regex_price_new')->nullable();
            $table->text('regex_price_preown')->nullable();
            $table->text('regex_price_buy')->nullable();
            $table->text('regex_price_voucher')->nullable();
            $table->timestamps();
        });
        Schema::create('competitors_listings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->integer('game_id')->nullable();
            $table->integer('competitor_id')->nullable();
            $table->string('url_new')->nullable();
            $table->string('url_preown')->nullable();
            $table->string('url_buy')->nullable();
            $table->string('url_voucher')->nullable();
            $table->integer('latest_price_new')->nullable();
            $table->integer('latest_price_preown')->nullable();
            $table->integer('latest_price_buy')->nullable();
            $table->integer('latest_price_voucher')->nullable();
            $table->timestamps();
        });
        Schema::create('competitors_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->nullable();
            $table->integer('price_new')->nullable();
            $table->integer('price_preown')->nullable();
            $table->integer('price_buy')->nullable();
            $table->integer('price_voucher')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitors');
        Schema::dropIfExists('competitors_listings');
        Schema::dropIfExists('competitors_prices');
    }
}
