<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsAndOthers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('run_id');
            $table->integer('user_id');
            $table->integer('game_id');
            $table->integer('stock_id');
            $table->timestamps();
        });

        Schema::create('assignment_runs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('date_of_run');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('retirement_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('stock', function (Blueprint $table) {
            $table->date('date_purchased')->after('game_id')->nulllable();
            $table->date('date_retired')->after('date_purchased')->nulllable();
            $table->integer('retired_reason_id')->after('date_retired')->nullable();
            $table->boolean('currently_in_stock')->after('retired_reason_id')->nullable();
            $table->integer('times_rented')->after('currently_in_stock')->nullable();
            $table->dropColumn('stock_movement');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->integer('num_in_stock')->after('slug')->nullable();
            $table->integer('num_available')->after('num_in_stock')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('num_games_on_rental')->after('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('assignment_runs');
        Schema::dropIfExists('retirement_reasons');

        Schema::table('stock', function (Blueprint $table) {
            $table->dropColumn('date_purchased');
            $table->dropColumn('date_retired');
            $table->dropColumn('retired_reason_id');
            $table->dropColumn('currently_in_stock');
            $table->dropColumn('times_rented');
            $table->integer('stock_movement')->after('game_id');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('num_in_stock');
            $table->dropColumn('num_available');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('num_games_on_rental');
        });
    }
}
