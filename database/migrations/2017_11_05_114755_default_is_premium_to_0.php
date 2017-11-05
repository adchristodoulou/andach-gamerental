<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultIsPremiumTo0 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function ($table) {
            $table->string('num_in_stock')->default(0)->nullable(false)->change();
            $table->string('num_available')->default(0)->nullable(false)->change();
            $table->string('is_premium')->default(0)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function ($table) {
            $table->string('num_in_stock')->nullable()->change();
            $table->string('num_available')->nullable()->change();
            $table->string('is_premium')->nullable()->change();
        });
    }
}
