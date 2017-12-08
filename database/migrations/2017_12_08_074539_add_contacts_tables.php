<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('category_id');
            $table->string('title');
            $table->text('full_text');
            $table->timestamp('closed_at')->nullable();
            $table->integer('closed_by')->nullable();
            $table->timestamps();
        });

        Schema::create('contacts_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id');
            $table->string('slug');
            $table->string('extension');
            $table->integer('user_id')->nullable();
            $table->string('filename');
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::create('contacts_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('contacts_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id');
            $table->integer('user_id')->nullable();
            $table->text('full_text');
            $table->timestamp('viewed_by_initial_user_at')->nullable();
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
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('contacts_attachments');
        Schema::dropIfExists('contacts_categories');
        Schema::dropIfExists('contacts_replies');
    }
}
