<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxgamespermonthToPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function ($table) {
            $table->integer('max_games_per_month')->after('name');
        });

        Schema::table('users', function ($table) {
            $table->integer('games_rented_this_month')->after('num_games_on_rental');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('max_games_per_month');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('games_rented_this_month');
        });
    }
}
