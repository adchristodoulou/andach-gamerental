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
            $table->string('name');
            $table->integer('system_id');
            $table->integer('rating_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->boolean('is_premium')->nullable();
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
