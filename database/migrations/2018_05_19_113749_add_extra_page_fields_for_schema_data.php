<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraPageFieldsForSchemaData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function ($table) {
            $table->integer('is_commentable')->nullable()->after('body');
            $table->integer('game_id')->nullable()->after('author_id');
        });
        
        Schema::create('pages_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_id');
            $table->string('user_id');
            $table->text('comment');
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
        Schema::table('pages', function ($table) {
            $table->dropColumn('is_commentable');
            $table->dropColumn('game_id');
        });
        Schema::dropIfExists('pages_comments');
    }
}
