<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('factory_id')->nullable()->after('current_stock');
            $table->string('type')->nullable()->after('factory_id');
            $table->string('production_date')->nullable()->after('type');
            $table->boolean('is_approved')->default(0)->after('production_date');

            $table->foreign('factory_id')->references('id')->on('factories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('factory_id');
            $table->dropColumn('type');
            $table->dropColumn('production_date');
            $table->dropColumn('is_approved');
        });
    }
}
