<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->date('date_purchased')->nullable();
            $table->date('date_retired')->nullable();
            $table->integer('retired_reason_id')->nullable();
            $table->boolean('currently_in_stock')->nullable();
            $table->integer('times_rented')->nullable();
            $table->integer('purchase_price')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('stock');
    }
}
