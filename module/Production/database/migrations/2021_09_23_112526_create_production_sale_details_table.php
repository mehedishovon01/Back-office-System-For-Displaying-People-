<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('production_sales_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('assign_qty');
            $table->decimal('price', 16, 2)->default(0);
            $table->decimal('total_amount', 16, 2)->default(0);
            $table->timestamps();

            $table->foreign('production_sales_id')->references('id')->on('production_sales')->onDelete('CASCADE');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_sale_details');
    }
}
