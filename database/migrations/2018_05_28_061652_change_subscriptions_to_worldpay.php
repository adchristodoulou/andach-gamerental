<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSubscriptionsToWorldpay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function ($table) {
            $table->integer('plan_id')->after('user_id')->nullable();
        });
        Schema::table('subscriptions', function ($table) {
            $table->date('starts_at')->after('plan_id')->nullable();
        });
        Schema::table('subscriptions', function ($table) {
            $table->date('next_billing_date')->after('ends_at')->nullable();
        });
        Schema::table('subscriptions', function ($table) {
            $table->dropColumn(['braintree_id', 'braintree_plan', 'name', 'quantity']);
        });

        Schema::create('subscriptions_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->decimal('charge');
            $table->date('date_charge_taken');
            $table->timestamps();
        });

        Schema::create('subscriptions_failures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id');
            $table->date('should_start_at');
            $table->date('should_end_at');
            $table->decimal('charge_attempted');
            $table->date('date_charge_attempted');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['braintree_id', 'paypal_email', 'card_brand', 'card_last_four', 'trial_ends_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('worldpay_token')->after('remember_token')->nullable();
        });

        Schema::table('invoices_lines', function (Blueprint $table) {
            $table->string('description')->after('product_id')->nullable();
            $table->decimal('net', 8, 2)->change();
            $table->decimal('vat', 8, 2)->change();
            $table->decimal('gross', 8, 2)->change();
            $table->decimal('net_per_item', 8, 2)->change();
            $table->decimal('vat_per_item', 8, 2)->change();
            $table->decimal('gross_per_item', 8, 2)->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('lines_net', 8, 2)->change();
            $table->decimal('lines_vat', 8, 2)->change();
            $table->decimal('lines_gross', 8, 2)->change();
            $table->decimal('shipping_net', 8, 2)->change();
            $table->decimal('shipping_vat', 8, 2)->change();
            $table->decimal('shipping_gross', 8, 2)->change();
            $table->decimal('net', 8, 2)->change();
            $table->decimal('vat', 8, 2)->change();
            $table->decimal('gross', 8, 2)->change();
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
            $table->dropColumn(['starts_at', 'next_billing_date', 'plan_id']);
            $table->string('name')->after('user_id');
            $table->string('quantity')->after('name');
            $table->string('braintree_id')->after('name');
            $table->string('braintree_plan')->after('braintree_id');
        });

        Schema::dropIfExists('subscriptions_charges');
        Schema::dropIfExists('subscriptions_failures');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('worldpay_token');

            $table->string('braintree_id')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
        });

        Schema::table('invoices_lines', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->integer('net')->change();
            $table->integer('vat')->change();
            $table->integer('gross')->change();
            $table->integer('net_per_item')->change();
            $table->integer('vat_per_item')->change();
            $table->integer('gross_per_item')->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('lines_net')->change();
            $table->integer('lines_vat')->change();
            $table->integer('lines_gross')->change();
            $table->integer('shipping_net')->change();
            $table->integer('shipping_vat')->change();
            $table->integer('shipping_gross')->change();
            $table->integer('net')->change();
            $table->integer('vat')->change();
            $table->integer('gross')->change();
        });
    }
}
