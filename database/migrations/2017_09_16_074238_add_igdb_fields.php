<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIgdbFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('slug')->after('name')->nulllable();
            $table->integer('collection_id')->after('system_id')->nullable();
            $table->integer('publisher_id')->after('collection_id')->nullable();
            $table->integer('franchise_id')->after('publisher_id')->nullable();
            $table->integer('developer_id')->after('franchise_id')->nullable();
            $table->integer('esrb_rating')->after('developer_id')->nullable();
            $table->text('esrb_synopsis')->after('esrb_rating')->nullable();
            $table->integer('pegi_rating')->after('esrb_synopsis')->nullable();
            $table->text('pegi_synopsis')->after('pegi_rating')->nullable();
            $table->integer('timetobeat_quick')->after('pegi_synopsis')->nullable();
            $table->integer('timetobeat_normal')->after('timetobeat_quick')->nullable();
            $table->integer('timetobeat_slow')->after('timetobeat_normal')->nullable();
            $table->integer('rating')->after('timetobeat_slow')->nullable();
            $table->integer('rating_count')->after('rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('collection_id');
            $table->dropColumn('publisher_id');
            $table->dropColumn('franchise_id');
            $table->dropColumn('developer_id');
            $table->dropColumn('esrb_rating');
            $table->dropColumn('esrb_synopsis');
            $table->dropColumn('pegi_rating');
            $table->dropColumn('pegi_synopsis');
            $table->dropColumn('timetobeat_slow');
            $table->dropColumn('timetobeat_normal');
            $table->dropColumn('timetobeat_quick');
            $table->dropColumn('rating');
            $table->dropColumn('rating_count');
        });
    }
}
