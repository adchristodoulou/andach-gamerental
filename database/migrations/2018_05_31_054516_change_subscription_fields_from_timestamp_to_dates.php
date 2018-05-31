<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSubscriptionFieldsFromTimestampToDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->date('trial_ends_at')->nullable()->change();
            $table->date('ends_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //The DBAL extension doesn't let us rename something to a timestamp column. It doesn't particularly matter,
            //there's nothing that can possibly rely on this. Even if we rollback (doing nothing) and then re-migrate this
            //migration, changing a date to a date column doesn't cause an error. 

            //$table->timestamp('trial_ends_at')->nullable()->change();
            //$table->timestamp('ends_at')->nullable()->change();
        });
    }
}
