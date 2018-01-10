<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackageAndSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('braintree_id')->default('')->after('billing_postcode');
        });
        Schema::table('users', function ($table) {
            $table->string('paypal_email')->default('')->after('braintree_id');
        });
        Schema::table('users', function ($table) {
            $table->string('card_brand')->default('')->after('paypal_email');
        });
        Schema::table('users', function ($table) {
            $table->string('card_last_four')->default('')->after('card_brand');
        });

        Schema::create('subscriptions', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('braintree_id');
            $table->string('braintree_plan');
            $table->integer('quantity');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('plans', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('max_games_simultaneously');
            $table->boolean('is_premium')->nullable();
            $table->boolean('is_priority')->nullable();
            $table->string('slug')->unique(); //name used to identify plan in the URL
            $table->string('braintree_plan');
            $table->float('cost');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('plans');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['braintree_id', 'paypal_email', 'card_brand', 'card_last_four', 'trial_ends_at']);
        });
    }
}
