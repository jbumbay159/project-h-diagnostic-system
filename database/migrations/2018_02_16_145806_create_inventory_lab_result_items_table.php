<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryLabResultItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_lab_result_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('sale_id')->unsigned();
            $table->integer('lab_result_id')->unsigned();
            $table->integer('supply_id')->unsigned();
            $table->integer('testqty')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('lab_result_id')->references('id')->on('lab_results');
            $table->foreign('supply_id')->references('id')->on('supplies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_lab_result_items');
    }
}
