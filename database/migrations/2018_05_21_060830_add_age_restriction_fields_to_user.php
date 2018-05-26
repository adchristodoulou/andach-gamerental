<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgeRestrictionFieldsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('maximum_age')->nullable()->after('marketing_subscribe');
            $table->string('maximum_age_hash')->nullable()->after('maximum_age');
            $table->datetime('maximum_age_expiry')->nullable()->after('maximum_age_hash');
            $table->integer('maximum_age_held')->nullable()->after('maximum_age_expiry');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('maximum_age');
            $table->dropColumn('maximum_age_hash');
            $table->dropColumn('maximum_age_expiry');
            $table->dropColumn('maximum_age_held');
        });
    }
}
