<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('password')->nullable();
            $table->string('middle_names')->after('first_name')->nullable();
            $table->string('last_name')->after('middle_names')->nullable();
            $table->string('telephone')->after('last_name')->nullable();

            $table->string('shipping_address1')->after('telephone')->nullable();
            $table->string('shipping_address2')->after('shipping_address1')->nullable();
            $table->string('shipping_address3')->after('shipping_address2')->nullable();
            $table->string('shipping_town')->after('shipping_address3')->nullable();
            $table->string('shipping_county')->after('shipping_town')->nullable();
            $table->string('shipping_postcode')->after('shipping_county')->nullable();

            $table->string('billing_address1')->after('shipping_postcode')->nullable();
            $table->string('billing_address2')->after('billing_address1')->nullable();
            $table->string('billing_address3')->after('billing_address2')->nullable();
            $table->string('billing_town')->after('billing_address3')->nullable();
            $table->string('billing_county')->after('billing_town')->nullable();
            $table->string('billing_postcode')->after('billing_county')->nullable();
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
            $table->dropColumn('first_name');
            $table->dropColumn('middle_names');
            $table->dropColumn('last_name');
            $table->dropColumn('telephone');

            $table->dropColumn('shipping_address1');
            $table->dropColumn('shipping_address2');
            $table->dropColumn('shipping_address3');
            $table->dropColumn('shipping_town');
            $table->dropColumn('shipping_county');
            $table->dropColumn('shipping_postcode');
            
            $table->dropColumn('billing_address1');
            $table->dropColumn('billing_address2');
            $table->dropColumn('billing_address3');
            $table->dropColumn('billing_town');
            $table->dropColumn('billing_county');
            $table->dropColumn('billing_postcode');
        });
    }
}
