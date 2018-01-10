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

        Schema::table('games', function (Blueprint $table) {
            $table->integer('num_in_stock')->after('slug')->default(0);
        });
        Schema::table('games', function (Blueprint $table) {
            $table->integer('num_available')->after('num_in_stock')->default(0);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('num_games_on_rental')->after('remember_token')->default(0);
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

        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('num_in_stock', 'num_available');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('num_games_on_rental');
        });
    }
}
