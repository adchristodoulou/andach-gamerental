<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIgdbTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('franchises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('screenshots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->string('url')->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->string('name')->nullable();
            $table->string('youtube_id')->nullable();
            $table->timestamps();
        });

        Schema::create('websites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->string('url')->nullable();
            $table->string('category_id')->nullable();
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('modes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('link_games_modes', function (Blueprint $table) {
            $table->integer('game_id')->nullable();
            $table->integer('mode_id')->nullable();
            $table->timestamps();
        });

        Schema::create('link_games_genres', function (Blueprint $table) {
            $table->integer('game_id')->nullable();
            $table->integer('genre_id')->nullable();
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
        Schema::dropIfExists('companies');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('franchises');
        Schema::dropIfExists('screenshots');
        Schema::dropIfExists('websites');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('modes');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('link_games_websites');
        Schema::dropIfExists('link_games_genres');
        Schema::dropIfExists('link_games_modes');
        Schema::dropIfExists('link_games_videos');
        Schema::dropIfExists('link_games_screenshots');
    }
}
