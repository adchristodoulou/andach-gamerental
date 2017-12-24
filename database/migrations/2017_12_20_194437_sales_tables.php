<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('user_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->integer('quantity_in_cart')->default(0);
            $table->timestamps();
        });

        Schema::create('deliverynotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->date('date_of_posting')->nullable();
            $table->string('shipping_address1')->nullable();
            $table->string('shipping_address2')->nullable();
            $table->string('shipping_address3')->nullable();
            $table->string('shipping_town')->nullable();
            $table->string('shipping_county')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->timestamps();
        });

        Schema::create('deliverynotes_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deliverynote_id');
            $table->integer('invoice_line_id');
            $table->integer('quantity_delivered');
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->date('date_of_invoice')->nullable();
            $table->date('date_of_finalising')->nullable();
            $table->date('date_of_shipping')->nullable();
            $table->integer('lines_net')->default(0);
            $table->integer('lines_vat')->default(0);
            $table->integer('lines_gross')->default(0);
            $table->integer('shipping_net')->default(0);
            $table->integer('shipping_vat')->default(0);
            $table->integer('shipping_gross')->default(0);
            $table->integer('net')->default(0);
            $table->integer('vat')->default(0);
            $table->integer('gross')->default(0);
            $table->string('invoice_address1')->nullable();
            $table->string('invoice_address2')->nullable();
            $table->string('invoice_address3')->nullable();
            $table->string('invoice_town')->nullable();
            $table->string('invoice_county')->nullable();
            $table->string('invoice_postcode')->nullable();
            $table->string('billing_address1')->nullable();
            $table->string('billing_address2')->nullable();
            $table->string('billing_address3')->nullable();
            $table->string('billing_town')->nullable();
            $table->string('billing_county')->nullable();
            $table->string('billing_postcode')->nullable();
            $table->timestamps();
        });

        Schema::create('invoices_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->integer('quantity_invoiced')->default(0);
            $table->integer('net')->default(0);
            $table->integer('vat')->default(0);
            $table->integer('gross')->default(0);
            $table->integer('net_per_item')->default(0);
            $table->integer('vat_per_item')->default(0);
            $table->integer('gross_per_item')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->nullable();
            $table->string('slug')->nullable();
            $table->integer('price')->default(0);
            $table->string('name')->nullable();
            $table->text('snippet')->nullable();
            $table->text('full_text')->nullable();
            $table->boolean('is_vatable')->nullable();
            $table->integer('num_in_stock')->default(0);
            $table->timestamps();
        });

        Schema::create('products_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('products_categories_link', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('category_id');
            $table->timestamps();
        });

        Schema::create('products_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('url')->nullable();
            $table->string('thumb_url')->nullable();
            $table->boolean('is_main')->nullable();
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
        Schema::dropIfExists('cart');
        Schema::dropIfExists('deliverynotes');
        Schema::dropIfExists('deliverynotes_lines');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoices_lines');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_categories');
        Schema::dropIfExists('products_categories_link');
        Schema::dropIfExists('products_pictures');
    }
}
