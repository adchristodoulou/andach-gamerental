<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('system_id')->nullable();
            $table->integer('collection_id')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->integer('franchise_id')->nullable();
            $table->integer('developer_id')->nullable();
            $table->integer('esrb_rating')->nullable();
            $table->text('esrb_synopsis')->nullable();
            $table->integer('pegi_rating')->nullable();
            $table->text('pegi_synopsis')->nullable();
            $table->integer('timetobeat_quick')->nullable();
            $table->integer('timetobeat_normal')->nullable();
            $table->integer('timetobeat_slow')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('rating_count')->nullable();
            $table->integer('rating_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('developer')->nullable();
            $table->string('publisher')->nullable();
            $table->text('description')->nullable();
            $table->string('trailer_url')->nullable();
            $table->date('release_date')->nullable();
            $table->boolean('is_premium')->nullable();
            $table->integer('min_players')->nullable();
            $table->integer('max_players')->nullable();
            //An integer here shows that this is local co-op for x or more players. 
            $table->integer('is_local_coop')->nullable();
            //An integer here shows that this is online co-op for x or more players. 
            $table->integer('is_online_coop')->nullable();
            $table->string('picture_url')->nullable();
            $table->string('thumb_url')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('games');
    }
}
