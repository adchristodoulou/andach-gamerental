<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddXboxAchievementFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('xbox_id')->nullable()->after('password');
            $table->string('xbox_username')->nullable()->after('xbox_id');
            $table->string('psn_id')->nullable()->after('xbox_username');
            $table->string('psn_username')->nullable()->after('psn_id');
        });

        Schema::table('games', function ($table) {
            $table->integer('max_gamerscore')->nullable()->after('description');
        });

        Schema::create('achievements', function ($table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('system_id');
            $table->integer('gamerscore')->nullable();
            $table->text('achievement_description')->nullable();
            $table->text('achievement_locked_description')->nullable();
            $table->string('trophy')->nullable();
            $table->text('trophy_description')->nullable();
            $table->text('trophy_locked_description')->nullable();
            $table->boolean('is_secret')->nullable();
            $table->boolean('is_rare')->nullable();
            $table->double('percentage_unlocked')->nullable();
            $table->timestamps();
        });

        Schema::create('achievements_earned', function ($table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('user_id');
            $table->datetime('date_of_earning');
            $table->timestamps();
        });

        Schema::create('achievements_requirements', function ($table) {
            $table->increments('id');
            $table->integer('achievement_id');
            $table->integer('target');
            $table->uuid('microsoft_guid');
            $table->string('value_type');
            $table->string('operation_type');
            $table->string('rule_participation_type');
            $table->timestamps();
        });
        
        Schema::create('achievements_requirements_progress', function ($table) {
            $table->increments('id');
            $table->integer('requirement_id');
            $table->integer('user_id');
            $table->double('value');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('xbox_id');
            $table->dropColumn('xbox_username');
            $table->dropColumn('psn_id');
            $table->dropColumn('psn_username');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('max_gamerscore');
        });

        Schema::dropIfExists('achievements');
        Schema::dropIfExists('achievements_earned');
        Schema::dropIfExists('achievements_requirements');
        Schema::dropIfExists('achievements_requirements_progress');
    }
}
