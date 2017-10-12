<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtraAssignmentFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function ($table) {
            $table->integer('rental_id')->nullable()->after('stock_id');
        });

        Schema::table('rentals', function ($table) {
            $table->integer('stock_id')->nullable()->after('game_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('rental_id');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('stock_id');
        });
    }
}
